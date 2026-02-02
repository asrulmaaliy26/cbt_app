
import { User, UserRole, Exam, ExamType, QuestionType, ExamResult } from './types';

export const MOCK_USERS: User[] = [
  { id: '1', name: 'Pak Budi (Pengawas)', role: UserRole.PENGAWAS, email: 'pengawas@edu.com' },
  { id: '4', name: 'Rizky Ramadhan', role: UserRole.SISWA, email: 'rizky@edu.com', class: 'XII-IPA-1' },
];

export const INITIAL_EXAMS: Exam[] = [
  {
    id: 'ex-1',
    title: 'UTS Matematika Semester Ganjil',
    type: ExamType.UTS,
    subject: 'Matematika',
    teacherId: '1',
    className: 'XII-IPA-1',
    startTime: '2023-10-25T08:00:00',
    durationMinutes: 90,
    isActive: false,
    isCameraRequired: true,
    questions: [
      {
        id: 'q1',
        type: QuestionType.PG,
        text: 'Berapakah hasil dari 25 x 4?',
        options: ['80', '90', '100', '110'],
        correctAnswer: '100',
        points: 50
      },
      {
        id: 'q2',
        type: QuestionType.ESSAY,
        text: 'Jelaskan bagaimana cara menghitung luas segitiga.',
        points: 50
      }
    ]
  }
];

export const MOCK_RESULTS: ExamResult[] = [
  {
    id: 'res-1',
    examId: 'ex-1',
    studentId: '4',
    studentName: 'Rizky Ramadhan',
    status: 'SUBMITTED',
    submittedAt: '2023-10-25T10:00:00',
    totalScore: 50,
    proctoringStats: {
      tabSwitchCount: 2,
      noFaceCount: 1
    },
    answers: [
      {
        questionId: 'q1',
        studentAnswer: '100',
        score: 50,
        maxScore: 50
      },
      {
        questionId: 'q2',
        studentAnswer: 'Rumusnya adalah 1/2 dikali alas dikali tinggi (1/2 * a * t).',
        score: 0,
        maxScore: 50
      }
    ]
  }
];
