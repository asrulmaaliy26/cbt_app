
import React, { useState, useEffect } from 'react';
import { User, Exam, StudentActivity, UserRole } from './types';
import { MOCK_USERS, INITIAL_EXAMS } from './constants';
import SiswaDashboard from './pages/SiswaDashboard';
import PengawasDashboard from './pages/PengawasDashboard';
import Sidebar from './components/Sidebar';

const App: React.FC = () => {
  const [currentUser, setCurrentUser] = useState<User | null>(null);
  const [exams, setExams] = useState<Exam[]>(INITIAL_EXAMS);
  const [activities, setActivities] = useState<StudentActivity[]>([]);
  const [activeMenu, setActiveMenu] = useState('Dashboard');

  // Simulation of persistent state
  useEffect(() => {
    const savedExams = localStorage.getItem('edu_exams');
    if (savedExams) setExams(JSON.parse(savedExams));
  }, []);

  const logout = () => {
    setCurrentUser(null);
    setActiveMenu('Dashboard');
  };

  if (!currentUser) {
    return (
      <div className="min-h-screen bg-slate-900 flex items-center justify-center p-4">
        <div className="max-w-md w-full bg-white rounded-3xl shadow-2xl p-10 text-center">
          <div className="w-20 h-20 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-xl shadow-indigo-200">
            <span className="text-4xl font-black text-white">E</span>
          </div>
          <h2 className="text-3xl font-black text-slate-800 mb-2">EduSmart CBT</h2>
          <p className="text-slate-500 mb-10 font-medium">Silahkan pilih akses masuk sistem</p>

          <div className="grid gap-4">
            <button
              onClick={() => {
                setCurrentUser(MOCK_USERS.find(u => u.role === UserRole.PENGAWAS) || null);
                setActiveMenu('Live Monitoring');
              }}
              className="w-full py-4 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 flex items-center justify-center gap-3"
            >
              MASUK SEBAGAI PENGAWAS
            </button>
            <button
              onClick={() => {
                setCurrentUser(MOCK_USERS.find(u => u.role === UserRole.SISWA) || null);
                setActiveMenu('Dashboard');
              }}
              className="w-full py-4 bg-white border-2 border-slate-200 text-slate-700 font-black rounded-2xl hover:border-indigo-600 hover:text-indigo-600 transition-all flex items-center justify-center gap-3"
            >
              MASUK SEBAGAI SISWA
            </button>
          </div>
        </div>
      </div>
    );
  }

  const updateExams = (updatedExams: Exam[]) => {
    setExams(updatedExams);
    localStorage.setItem('edu_exams', JSON.stringify(updatedExams));
  };

  return (
    <div className="flex h-screen bg-slate-50 overflow-hidden">
      <Sidebar user={currentUser} onLogout={logout} activeMenu={activeMenu} onMenuChange={setActiveMenu} />

      <main className="flex-1 overflow-y-auto p-4 md:p-8">
        <header className="mb-8 flex justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-slate-100">
          <div>
            <h1 className="text-2xl font-bold text-slate-800">EduSmart CBT</h1>
            <p className="text-slate-500 text-sm">Selamat datang, {currentUser.name}</p>
          </div>
          {currentUser.class && (
            <span className="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-100">
              {currentUser.class}
            </span>
          )}
        </header>

        {currentUser.role === UserRole.SISWA && (
          <SiswaDashboard
            user={currentUser}
            exams={exams}
            setActivities={setActivities}
            activities={activities}
          />
        )}

        {currentUser.role === UserRole.PENGAWAS && (
          <PengawasDashboard
            exams={exams}
            onUpdateExams={updateExams}
            activities={activities}
            setActivities={setActivities}
          />
        )}
      </main>
    </div>
  );
};

export default App;
