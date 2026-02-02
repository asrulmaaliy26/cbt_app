
import React, { useState, useEffect, useRef } from 'react';
import { Exam, StudentActivity } from '../types';
import { 
  Power, UserCheck, AlertTriangle, Monitor, MoreVertical, 
  Search, CheckCircle2, VideoOff, Video, Bell, X, ShieldAlert, ScanSearch 
} from 'lucide-react';

interface Notification {
  id: string;
  studentId: string;
  message: string;
  reason?: string;
  type: 'WARNING' | 'VIOLATION';
  timestamp: Date;
}

interface PengawasDashboardProps {
  exams: Exam[];
  onUpdateExams: (exams: Exam[]) => void;
  activities: StudentActivity[];
  setActivities: React.Dispatch<React.SetStateAction<StudentActivity[]>>;
}

const PengawasDashboard: React.FC<PengawasDashboardProps> = ({ exams, onUpdateExams, activities, setActivities }) => {
  const [filterClass, setFilterClass] = useState('Semua Kelas');
  const [activeTab, setActiveTab] = useState<'MONITOR' | 'CONTROL'>('MONITOR');
  const [notifications, setNotifications] = useState<Notification[]>([]);
  const prevActivitiesRef = useRef<StudentActivity[]>([]);

  useEffect(() => {
    activities.forEach(curr => {
      const prev = prevActivitiesRef.current.find(a => a.studentId === curr.studentId && a.examId === curr.examId);
      
      // Detection: Suspicious Status Change
      if (curr.status === 'SUSPICIOUS' && (!prev || prev.status !== 'SUSPICIOUS')) {
        addNotification(
          curr.studentId, 
          curr.violationReason || 'Terdeteksi aktivitas mencurigakan!', 
          'VIOLATION'
        );
      }
      
      // Detection: Tab Switch Increase
      if (prev && curr.tabSwitchCount > prev.tabSwitchCount) {
        addNotification(curr.studentId, `Tab Switching (${curr.tabSwitchCount}x)`, 'VIOLATION');
      }

      // Detection: Camera Disabled
      if (prev && prev.cameraEnabled && !curr.cameraEnabled) {
        addNotification(curr.studentId, 'Mematikan kamera saat ujian!', 'WARNING');
      }
    });
    
    prevActivitiesRef.current = activities;
  }, [activities]);

  const addNotification = (studentId: string, message: string, type: 'WARNING' | 'VIOLATION') => {
    const newNotify: Notification = {
      id: Math.random().toString(36).substr(2, 9),
      studentId,
      message,
      type,
      timestamp: new Date()
    };
    setNotifications(prev => [newNotify, ...prev].slice(0, 5));
    
    setTimeout(() => {
      setNotifications(prev => prev.filter(n => n.id !== newNotify.id));
    }, 10000);
  };

  const removeNotification = (id: string) => {
    setNotifications(prev => prev.filter(n => n.id !== id));
  };

  const toggleExam = (examId: string) => {
    const updated = exams.map(e => e.id === examId ? { ...e, isActive: !e.isActive } : e);
    onUpdateExams(updated);
  };

  const resetStatus = (studentId: string) => {
    setActivities(prev => prev.map(a => 
      a.studentId === studentId ? { ...a, status: 'ONLINE', violationReason: undefined } : a
    ));
  };

  return (
    <div className="space-y-6 relative">
      <div className="fixed top-24 right-8 z-[100] w-80 space-y-3 pointer-events-none">
        {notifications.map((n) => (
          <div 
            key={n.id} 
            className={`pointer-events-auto p-4 rounded-2xl shadow-2xl border-l-4 flex gap-4 animate-in slide-in-from-right duration-300 ${
              n.type === 'VIOLATION' 
                ? 'bg-red-50 border-red-600 text-red-900' 
                : 'bg-amber-50 border-amber-500 text-amber-900'
            }`}
          >
            <div className={`shrink-0 w-10 h-10 rounded-xl flex items-center justify-center ${
              n.type === 'VIOLATION' ? 'bg-red-200 text-red-700' : 'bg-amber-200 text-amber-700'
            }`}>
              <ShieldAlert size={20} />
            </div>
            <div className="flex-1">
              <div className="flex justify-between items-start">
                <p className="font-black text-[10px] uppercase tracking-widest text-slate-400">SISWA {n.studentId.slice(-4)}</p>
                <button onClick={() => removeNotification(n.id)} className="text-slate-400 hover:text-slate-600">
                  <X size={14} />
                </button>
              </div>
              <p className="text-sm font-black mt-0.5 leading-snug">{n.message}</p>
            </div>
          </div>
        ))}
      </div>

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <div className="flex bg-slate-100 p-1 rounded-lg">
          <button 
            onClick={() => setActiveTab('MONITOR')}
            className={`px-6 py-2 text-sm font-black rounded-md transition-all flex items-center gap-2 ${activeTab === 'MONITOR' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-800'}`}
          >
            <Monitor size={16} /> LIVE MONITOR
          </button>
          <button 
            onClick={() => setActiveTab('CONTROL')}
            className={`px-6 py-2 text-sm font-black rounded-md transition-all flex items-center gap-2 ${activeTab === 'CONTROL' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-800'}`}
          >
            <Power size={16} /> KONTROL
          </button>
        </div>
        <div className="flex items-center gap-3">
          <div className="relative">
             <Search className="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" size={16} />
             <input placeholder="Cari Siswa..." className="pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm outline-none w-64 focus:ring-2 focus:ring-indigo-500 transition-all" />
          </div>
        </div>
      </div>

      {activeTab === 'CONTROL' ? (
        <div className="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
          <table className="w-full text-left">
            <thead className="bg-slate-50 border-b border-slate-200">
              <tr>
                <th className="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-widest">Judul Ujian</th>
                <th className="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-widest text-center">Status</th>
                <th className="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-widest text-center">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100">
              {exams.map(exam => (
                <tr key={exam.id} className="hover:bg-slate-50 transition-colors">
                  <td className="px-6 py-4">
                    <p className="font-black text-slate-800">{exam.title}</p>
                    <p className="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{exam.subject} • {exam.className}</p>
                  </td>
                  <td className="px-6 py-4 text-center">
                    <span className={`px-3 py-1 rounded-full text-[10px] font-black border ${exam.isActive ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-slate-50 text-slate-400 border-slate-100'}`}>
                      {exam.isActive ? 'BERLANGSUNG' : 'NON-AKTIF'}
                    </span>
                  </td>
                  <td className="px-6 py-4 text-center">
                    <button onClick={() => toggleExam(exam.id)} className={`px-4 py-2 rounded-xl text-xs font-black transition-all ${exam.isActive ? 'bg-red-50 text-red-600 hover:bg-red-600 hover:text-white' : 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-lg shadow-indigo-100'}`}>
                      {exam.isActive ? 'Hentikan' : 'Aktifkan'}
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      ) : (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          {activities.length === 0 ? (
            <div className="col-span-full py-32 text-center bg-white rounded-3xl border-2 border-dashed border-slate-200">
               <Monitor size={64} className="mx-auto mb-4 text-slate-200" />
               <p className="text-xl font-black text-slate-400">BELUM ADA SESI AKTIF</p>
            </div>
          ) : (
            activities.map(activity => (
              <div 
                key={activity.studentId} 
                className={`bg-white rounded-2xl border-2 transition-all overflow-hidden relative group ${
                  activity.status === 'SUSPICIOUS' 
                    ? 'border-red-500 shadow-2xl shadow-red-100 animate-pulse-red' 
                    : 'border-slate-200 hover:border-indigo-300'
                }`}
              >
                <div className="relative aspect-video bg-black flex items-center justify-center">
                  {activity.cameraEnabled ? (
                    <>
                      <img src={`https://picsum.photos/seed/${activity.studentId}/400/225`} className={`w-full h-full object-cover ${activity.status === 'SUSPICIOUS' ? 'opacity-40 blur-[1px]' : 'opacity-80'}`} />
                      <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent flex flex-col justify-end p-3">
                         <div className="flex items-center gap-2">
                           <div className={`w-2 h-2 rounded-full ${activity.status === 'SUSPICIOUS' ? 'bg-red-500' : 'bg-emerald-500 animate-pulse'}`}></div>
                           <p className="text-white text-xs font-black tracking-tight">SISWA-{activity.studentId.slice(-4)}</p>
                         </div>
                      </div>
                    </>
                  ) : (
                    <div className="text-slate-600 flex flex-col items-center gap-2"><VideoOff size={32} /><span className="text-[10px] font-black uppercase opacity-50 tracking-widest">No Camera Feed</span></div>
                  )}

                  {activity.status === 'SUSPICIOUS' && (
                    <div className="absolute inset-0 flex flex-col items-center justify-center p-4 bg-red-600/20 backdrop-blur-[2px]">
                       <div className="bg-red-600 text-white px-3 py-1 rounded-full flex items-center gap-2 font-black text-[10px] shadow-xl border border-white/20 uppercase tracking-widest">
                          <ShieldAlert size={14} /> Warning
                       </div>
                       <p className="text-white font-black text-[11px] text-center mt-2 drop-shadow-lg leading-tight">
                         {activity.violationReason || 'Aktivitas Mencurigakan'}
                       </p>
                    </div>
                  )}
                </div>

                <div className="p-4">
                  <div className="flex justify-between items-center mb-3">
                    <span className="px-2 py-1 bg-slate-100 text-slate-500 rounded text-[9px] font-black uppercase tracking-widest">XII-IPA-1</span>
                    <div className="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                       <ScanSearch size={14} className={activity.status === 'SUSPICIOUS' ? 'text-red-500' : 'text-emerald-500'} /> AI Proctor
                    </div>
                  </div>

                  <div className={`flex flex-col gap-2 p-3 rounded-xl border transition-all ${
                    activity.status === 'SUSPICIOUS' ? 'bg-red-50 border-red-100' : 'bg-emerald-50 border-emerald-100'
                  }`}>
                    <div className="flex justify-between items-center">
                      <p className={`text-[10px] font-black uppercase tracking-widest ${activity.status === 'SUSPICIOUS' ? 'text-red-600' : 'text-emerald-600'}`}>
                        {activity.status === 'SUSPICIOUS' ? 'Peringatan Sistem' : 'Status: Normal'}
                      </p>
                      {activity.tabSwitchCount > 0 && <span className="text-[9px] bg-red-600 text-white px-1.5 py-0.5 rounded-md font-black">{activity.tabSwitchCount}x Tab</span>}
                    </div>
                    {activity.status === 'SUSPICIOUS' && (
                      <button onClick={() => resetStatus(activity.studentId)} className="w-full py-2 bg-slate-900 text-white text-[10px] font-black rounded-lg hover:bg-slate-800 transition-all uppercase tracking-widest">Hapus Peringatan</button>
                    )}
                  </div>
                </div>
              </div>
            ))
          )}
        </div>
      )}

      <style>{`
        @keyframes pulse-red {
          0% { border-color: #ef4444; box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
          70% { border-color: #ef4444; box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
          100% { border-color: #ef4444; box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
        .animate-pulse-red { animation: pulse-red 2s infinite; }
      `}</style>
    </div>
  );
};

export default PengawasDashboard;
