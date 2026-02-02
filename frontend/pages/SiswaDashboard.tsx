
import React, { useState, useEffect, useRef } from 'react';
import { User, Exam, StudentActivity, QuestionType, Answer } from '../types';
import { Clock, Play, AlertCircle, Maximize2, Camera, ShieldAlert, MonitorCheck, ArrowRight, VideoOff, ImageIcon, X, Paperclip, FileText, Download, ArrowLeft, ScanSearch } from 'lucide-react';

interface SiswaDashboardProps {
  user: User;
  exams: Exam[];
  setActivities: React.Dispatch<React.SetStateAction<StudentActivity[]>>;
  activities: StudentActivity[]; // Needed to listen for remote status changes
}

const SiswaDashboard: React.FC<SiswaDashboardProps> = ({ user, exams, setActivities, activities }) => {
  const [activeExam, setActiveExam] = useState<Exam | null>(null);
  const [stream, setStream] = useState<MediaStream | null>(null);
  const [cameraError, setCameraError] = useState(false);
  const [isExamStarted, setIsExamStarted] = useState(false);
  const [suspiciousAlert, setSuspiciousAlert] = useState<string | null>(null);
  const [answers, setAnswers] = useState<Record<string, Answer>>({});
  const videoRef = useRef<HTMLVideoElement>(null);
  const lastFrameDataRef = useRef<Uint8ClampedArray | null>(null);
  const noMotionCounterRef = useRef<number>(0);
  const localNoFaceCountRef = useRef<number>(0);
  const motionDetectionIntervalRef = useRef<number | null>(null);

  const isCameraReady = !!stream;
  const classExams = exams.filter(e => e.className === user.class);

  // Listen for Remote Termination (Force Submit by Admin)
  useEffect(() => {
    if (isExamStarted) {
      const myActivity = activities.find(a => a.studentId === user.id && a.examId === activeExam?.id);
      if (myActivity?.status === 'FINISHED' && myActivity.violationReason?.includes('Submit Paksa')) {
        alert('SESI DIAKHIRI: Pengawas telah mengakhiri ujian Anda dikarenakan pelanggaran yang terlalu banyak.');
        handleBackToDashboard();
      }
    }
  }, [activities, user.id, isExamStarted, activeExam?.id]);

  // Motion Detection Engine
  useEffect(() => {
    if (!isExamStarted || !stream || !videoRef.current) return;

    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d', { willReadFrequently: true });
    canvas.width = 64; 
    canvas.height = 48;

    const detectMotion = () => {
      if (!ctx || !videoRef.current) return;
      
      ctx.drawImage(videoRef.current, 0, 0, canvas.width, canvas.height);
      const currentFrame = ctx.getImageData(0, 0, canvas.width, canvas.height).data;

      if (lastFrameDataRef.current) {
        let diff = 0;
        const lastFrame = lastFrameDataRef.current;
        
        for (let i = 0; i < currentFrame.length; i += 8) {
          const rDiff = Math.abs(currentFrame[i] - lastFrame[i]);
          const gDiff = Math.abs(currentFrame[i+1] - lastFrame[i+1]);
          const bDiff = Math.abs(currentFrame[i+2] - lastFrame[i+2]);
          if (rDiff + gDiff + bDiff > 40) diff++;
        }

        const motionThreshold = 20; 
        if (diff < motionThreshold) {
          noMotionCounterRef.current += 1;
        } else {
          noMotionCounterRef.current = 0;
        }

        // Trigger violation every 10 seconds of no-face (at 500ms sample rate)
        if (noMotionCounterRef.current > 20) {
          localNoFaceCountRef.current += 1;
          setSuspiciousAlert('PERINGATAN: Wajah/Pergerakan tidak terdeteksi!');
          setActivities(prev => prev.map(a => 
            a.studentId === user.id ? { 
              ...a, 
              status: 'SUSPICIOUS', 
              violationReason: 'No Movement/Person Detected',
              noFaceCount: localNoFaceCountRef.current 
            } : a
          ));
          noMotionCounterRef.current = 0; 
        }
      }
      
      lastFrameDataRef.current = currentFrame;
    };

    motionDetectionIntervalRef.current = window.setInterval(detectMotion, 500);
    return () => { if (motionDetectionIntervalRef.current) clearInterval(motionDetectionIntervalRef.current); };
  }, [isExamStarted, stream, user.id, setActivities]);

  // Tab Switching Detection
  useEffect(() => {
    if (!isExamStarted) return;
    const handleVisibilityChange = () => {
      if (document.hidden) {
        setSuspiciousAlert('PERINGATAN: Dilarang meninggalkan halaman ujian!');
        setActivities(prev => prev.map(a => 
          a.studentId === user.id ? { 
            ...a, 
            status: 'SUSPICIOUS', 
            violationReason: 'Tab Switching', 
            tabSwitchCount: a.tabSwitchCount + 1 
          } : a
        ));
      }
    };
    document.addEventListener('visibilitychange', handleVisibilityChange);
    return () => document.removeEventListener('visibilitychange', handleVisibilityChange);
  }, [isExamStarted, user.id, setActivities]);

  useEffect(() => {
    if (stream && videoRef.current) { videoRef.current.srcObject = stream; }
  }, [stream, activeExam, isExamStarted]);

  const startCamera = async () => {
    try {
      const mediaStream = await navigator.mediaDevices.getUserMedia({ video: { width: 640, height: 480 }, audio: false });
      setStream(mediaStream);
      setCameraError(false);
    } catch (err) {
      setCameraError(true);
      setStream(null);
    }
  };

  const stopCamera = () => {
    if (stream) { stream.getTracks().forEach(track => track.stop()); setStream(null); }
  };

  const startExam = (exam: Exam) => {
    if (!exam.isActive) return alert('Ujian belum diaktifkan.');
    setActiveExam(exam);
    startCamera();
  };

  const confirmStart = () => {
    if (!isCameraReady && activeExam?.isCameraRequired) { return alert('Kamera wajib aktif.'); }
    try { if (document.documentElement.requestFullscreen) document.documentElement.requestFullscreen(); } catch (e) {}
    setIsExamStarted(true);
    setActivities(prev => [...prev, { 
      studentId: user.id, 
      examId: activeExam!.id, 
      status: 'ONLINE', 
      cameraEnabled: isCameraReady, 
      tabSwitchCount: 0, 
      noFaceCount: 0,
      lastSeen: new Date().toISOString() 
    }]);
  };

  const handleBackToDashboard = () => { 
    stopCamera(); 
    setActiveExam(null); 
    setIsExamStarted(false); 
    try { if (document.exitFullscreen) document.exitFullscreen(); } catch (e) {}
  };

  if (isExamStarted && activeExam) {
    return (
      <div className="fixed inset-0 z-50 bg-slate-900 flex flex-col h-screen">
        {suspiciousAlert && (
          <div className="absolute top-10 left-1/2 -translate-x-1/2 z-[60] bg-red-600 text-white px-8 py-6 rounded-2xl shadow-2xl text-center border-4 border-white animate-bounce">
            <ShieldAlert size={48} className="mx-auto mb-4" />
            <p className="text-xl font-black uppercase">{suspiciousAlert}</p>
            <p className="mt-2 text-sm opacity-80">Pelanggaran dicatat oleh Proctor AI.</p>
            <button onClick={() => setSuspiciousAlert(null)} className="mt-6 px-6 py-2 bg-white text-red-600 font-bold rounded-lg">Lanjutkan</button>
          </div>
        )}
        <div className="flex-1 flex overflow-hidden">
          <div className="flex-1 overflow-y-auto p-12 bg-white rounded-tr-3xl">
             <div className="max-w-3xl mx-auto">
               <div className="flex justify-between items-center mb-12 border-b pb-6">
                 <div><h1 className="text-3xl font-black text-slate-800">{activeExam.title}</h1><p className="text-slate-500 font-medium">{user.name}</p></div>
                 <div className="bg-indigo-50 px-6 py-4 rounded-2xl border border-indigo-100 flex items-center gap-4"><Clock className="text-indigo-600" size={24} /><div className="text-right"><p className="text-xs font-bold text-indigo-400 uppercase">Sisa Waktu</p><p className="text-2xl font-black text-indigo-700">01:29:59</p></div></div>
               </div>
               <div className="space-y-12">
                 {activeExam.questions.map((q, idx) => (
                   <div key={q.id} className="space-y-6 pb-8 border-b border-slate-50">
                     <div className="flex items-start gap-4">
                       <span className="w-10 h-10 flex items-center justify-center bg-slate-800 text-white rounded-xl font-bold shrink-0">{idx + 1}</span>
                       <p className="text-xl text-slate-800 font-medium">{q.text}</p>
                     </div>
                     <textarea className="w-full ml-14 p-5 rounded-2xl border-2 border-slate-100 min-h-[150px]" placeholder="Jawaban Anda..." />
                   </div>
                 ))}
               </div>
               <div className="mt-12 flex justify-end"><button onClick={handleBackToDashboard} className="px-10 py-4 bg-emerald-600 text-white font-black text-lg rounded-2xl shadow-xl">Kumpulkan Jawaban</button></div>
             </div>
          </div>
          <div className="w-80 bg-slate-900 p-6 flex flex-col gap-6">
             <div className="rounded-2xl overflow-hidden border-2 border-slate-700 bg-black aspect-video relative">
               <video ref={videoRef} autoPlay playsInline muted className="w-full h-full object-cover scale-x-[-1]" />
               <div className="absolute top-2 left-2 flex items-center gap-1 bg-black/40 backdrop-blur-md px-2 py-1 rounded text-[9px] font-black text-emerald-400 uppercase border border-emerald-400/20">
                  <ScanSearch size={10} className="animate-pulse" /> Monitoring Aktif
               </div>
             </div>
             <div className="bg-slate-800/50 p-4 rounded-xl border border-slate-700">
                <p className="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Sesi Info</p>
                <div className="space-y-2">
                   <div className="flex justify-between text-[10px] text-slate-300 font-bold"><span>Tab Switch:</span> <span className="text-red-400">0x</span></div>
                   <div className="flex justify-between text-[10px] text-slate-300 font-bold"><span>Camera Out:</span> <span className="text-red-400">{localNoFaceCountRef.current}x</span></div>
                </div>
             </div>
          </div>
        </div>
      </div>
    );
  }

  if (activeExam) {
    return (
      <div className="max-w-2xl mx-auto space-y-8 py-10">
        <button onClick={handleBackToDashboard} className="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold flex items-center gap-2 hover:bg-slate-50">
          <ArrowLeft size={20} /> Kembali
        </button>
        <div className="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden p-8 space-y-8">
            <h2 className="text-3xl font-black text-slate-800">{activeExam.title}</h2>
            <div className="bg-indigo-50 p-6 rounded-2xl flex items-center gap-6">
              <div className="w-24 h-24 bg-black rounded-xl overflow-hidden relative shadow-inner">
                {isCameraReady ? (<video ref={videoRef} autoPlay playsInline muted className="w-full h-full object-cover scale-x-[-1]" />) : (<div className="w-full h-full flex items-center justify-center text-indigo-200 bg-slate-800"><Camera size={32} /></div>)}
              </div>
              <div className="flex-1">
                <h4 className="font-bold text-indigo-900">Validasi Kamera</h4>
                <p className="text-sm text-indigo-600">{isCameraReady ? 'Sudah siap.' : 'Aktifkan kamera untuk mulai.'}</p>
                {!isCameraReady && (<button onClick={startCamera} className="mt-3 text-xs font-black bg-indigo-600 text-white px-4 py-2 rounded-lg">AKTIFKAN</button>)}
              </div>
            </div>
            <button onClick={confirmStart} className={`w-full py-5 rounded-2xl font-black text-xl shadow-xl ${isCameraReady ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'bg-slate-100 text-slate-400 cursor-not-allowed'}`}>MULAI UJIAN <ArrowRight className="inline ml-2" /></button>
        </div>
      </div>
    );
  }

  return (
    <div className="space-y-8">
      <div><h2 className="text-2xl font-black text-slate-800">CBT Student Center</h2><p className="text-slate-500">Pilih ujian yang tersedia untuk kelas Anda.</p></div>
      <div className="space-y-4 max-w-2xl">
        {classExams.map(exam => (
          <div key={exam.id} className="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between group">
            <div><h4 className="font-bold text-slate-800 text-lg">{exam.title}</h4><p className="text-slate-500 text-sm">{exam.subject} • {exam.durationMinutes} Menit</p></div>
            <button onClick={() => startExam(exam)} className={`flex items-center gap-2 px-6 py-3 rounded-xl font-bold transition-all ${exam.isActive ? 'bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white' : 'bg-slate-50 text-slate-300'}`}>MASUK</button>
          </div>
        ))}
      </div>
    </div>
  );
};

export default SiswaDashboard;
