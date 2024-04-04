import { HashRouter as Router, Route, Routes, Outlet, Navigate } from "react-router-dom";
import { Suspense, lazy } from 'react';
import InstructorLayout from '@/components/layouts/InstructorLayout';
import StudentLayout from '@/components/layouts/StudentLayout';
import RoleChecker from "@/components/layouts/RoleChecker";
import SignIn from "@/pages/SignIn";
import ProtectedRoute from "@/components/ProtectedRoute";
import { ABS_INS_URL, REL_INS_URL, ABS_STU_URL, REL_STU_URL, COMMON_URL } from "@/utils/constants/routeConst";

// Lazy-load page components
const MyGroups = lazy(() => import('@/pages/MyGroups'));
const AddExercise = lazy(() => import('@/pages/AddExercise'));
const Chapter = lazy(() => import('@/pages/Chapter'));
const AvailableGroups = lazy(() => import('@/pages/AvailableGroups'));
const StudentList = lazy(() => import('@/pages/StudentList'));
const StudentScore = lazy(() => import('@/pages/StudentScore'));
const InsGroup = lazy(() => import('@/pages/InsGroup'));
const SubmissionHistory = lazy(() => import('@/pages/SubmissionHistory'));
const StuExercise = lazy(() => import('@/pages/StuExercise'));
const EditExercise = lazy(() => import('@/pages/EditExercise'));
const StuExerciseList = lazy(() => import('@/pages/StuExerciseList'));
const StuHome = lazy(() => import('@/pages/StuHome'));
const AddGroup = lazy(() => import('@/pages/AddGroup'));
const EditGroup = lazy(() => import('@/pages/EditGroup'));
const LogPage = lazy(() => import('@/pages/LogPage'));
const AddMidtermScore = lazy(() => import('@/pages/AddMidtermScore'));
const EditProfile = lazy(() => import('@/pages/EditProfile'));
const Faq = lazy(() => import('@/pages/Faq'));
const Examination = lazy(() => import('@/pages/Examination'));
const Instruction = lazy(() => import('@/pages/Instructions'));
const AddStudent = lazy(() => import('@/pages/AddStudent'));

const Loading = () => <div style={{ padding: "40px" }} >Loading...</div>;

const RouterComponent = () => {
  return (
    <Router>
      <Routes>
        <Route index element={<Navigate to={COMMON_URL.STATIC.SIGNIN} />} />
        <Route path="*" element={<div>Page not found...</div>} />
        <Route element={
          <ProtectedRoute>
            <RoleChecker role="supervisor" >
              <InstructorLayout />
            </RoleChecker>
          </ProtectedRoute>
        }>
          <Route path={ABS_INS_URL.STATIC.MY_GROUPS} element={<Outlet />} >
            <Route index element={<Suspense fallback={<Loading />}><MyGroups /></Suspense>} />
            <Route path={REL_INS_URL.DYNAMIC.GROUP()} element={<Suspense fallback={<Loading />}><InsGroup /></Suspense>} />
            <Route path={REL_INS_URL.DYNAMIC.CHAPTER()} element={<Suspense fallback={<Loading />}><Chapter /></Suspense>} />
            <Route path={REL_INS_URL.DYNAMIC.ADD_EXERCISE()} element={<Suspense fallback={<Loading />}><AddExercise /></Suspense>} />
            <Route path={REL_INS_URL.DYNAMIC.EDIT_EXERCISE()} element={<Suspense fallback={<Loading />}><EditExercise /></Suspense>} />
            <Route path={REL_INS_URL.DYNAMIC.STUDENT_LIST()} element={<Suspense fallback={<Loading />}><StudentList /></Suspense>} />
            <Route path={REL_INS_URL.DYNAMIC.ADD_STUDENT()} element={<Suspense fallback={<Loading />}><AddStudent /></Suspense>} />
            <Route path={REL_INS_URL.DYNAMIC.ADD_MIDTERM_SCORE()} element={<Suspense fallback={<Loading />}><AddMidtermScore /></Suspense>} />
            <Route path={REL_INS_URL.DYNAMIC.STUDENT_SCORE()} element={<Suspense fallback={<Loading />}><StudentScore /></Suspense>} />
            <Route path={REL_INS_URL.DYNAMIC.STUDENT_SUBMIT_HISTORY()} element={<Suspense fallback={<Loading />}><SubmissionHistory /></Suspense>} />
            <Route path={REL_INS_URL.STATIC.AVAILABLE_GROUPS} element={<Suspense fallback={<Loading />}><AvailableGroups /></Suspense>} />
            <Route path={REL_INS_URL.STATIC.INSTRUCTION} element={<Suspense fallback={<Loading />}><Instruction /></Suspense>} />
            <Route path={REL_INS_URL.STATIC.EXAMINATION} element={<Suspense fallback={<Loading />}><Examination /></Suspense>} />
            <Route path={REL_INS_URL.STATIC.FAQ} element={<Suspense fallback={<Loading />}><Faq /></Suspense>} />
            <Route path={REL_INS_URL.DYNAMIC.PROFILE()} element={<Suspense fallback={<Loading />}><EditProfile /></Suspense>} />
            <Route path={REL_INS_URL.STATIC.ADDGROUP} element={<Suspense fallback={<Loading />}><AddGroup /></Suspense>} />
            <Route path={REL_INS_URL.DYNAMIC.EDITGROUP()} element={<Suspense fallback={<Loading />}><EditGroup /></Suspense>} />
            <Route path={REL_INS_URL.DYNAMIC.LOGPAGE()} element={<Suspense fallback={<Loading />}><LogPage /></Suspense>} />
          </Route>
        </Route>
        <Route path={COMMON_URL.STATIC.SIGNIN} element={<SignIn />} />
        <Route path={ABS_STU_URL.STATIC.HOME} element={
          <ProtectedRoute>
            <RoleChecker role="student" >
              <StudentLayout />
            </RoleChecker>
          </ProtectedRoute>
        } >
          <Route index element={<Suspense fallback={<Loading />}><StuHome /></Suspense>} />
          <Route path={REL_STU_URL.STATIC.EXERCISE_LIST} element={<Suspense fallback={<Loading />}><StuExerciseList /></Suspense>} />
          <Route path={REL_STU_URL.DYNAMIC.EXERCISE()} element={<Suspense fallback={<Loading />}><StuExercise /></Suspense>} />
          <Route path={REL_STU_URL.STATIC.INSTRUCTION} element={<Suspense fallback={<Loading />}><Instruction /></Suspense>} />
          <Route path={REL_STU_URL.STATIC.EXAMINATION} element={<Suspense fallback={<Loading />}><Examination /></Suspense>} />
          <Route path={REL_STU_URL.STATIC.FAQ} element={<Suspense fallback={<Loading />}><Faq /></Suspense>} />
          <Route path={REL_STU_URL.DYNAMIC.PROFILE()} element={<EditProfile />} />
        </Route>
      </Routes>
    </Router >
  )
}

export default RouterComponent;