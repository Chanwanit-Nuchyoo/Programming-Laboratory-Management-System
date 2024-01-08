import axios from "axios"
import stripBom from 'strip-bom';
import qs from 'qs'

export const getLabChapterInfo = async (groupId, labNo) => {
  const { data } = await axios.get(`${import.meta.env.VITE_BASE_URL}/index.php/supervisor_rest/getLabChapterInfo?group_id=${groupId}&lab_no=${labNo}`, { withCredentials: true })
  return data.payload
}

export const getAllAvailableGroups = async () => {
  const { data } = await axios.get(`${import.meta.env.VITE_BASE_URL}/index.php/supervisor_rest/getAllAvailableGroups?year=${import.meta.env.VITE_YEAR}`, { withCredentials: true });
  return data.payload
}

export const getGroupListById = async () => {
  const { data } = await axios.get(`${import.meta.env.VITE_BASE_URL}/index.php/supervisor_rest/getGroupListById?year=${import.meta.env.VITE_YEAR}`, { withCredentials: true });
  return data.payload.group_list
}

export const getStudentListInGroupWithLabScore = async (groupId) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BASE_URL}/index.php/supervisor_rest/getStudentListInGroupWithLabScore?group_id=${groupId}`,
    { withCredentials: true }
  );
  return data.payload;
}

export const getAddExercisePageInfo = async (groupId, chapterId) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BASE_URL}/index.php/supervisor_rest/getAddExercisePageInfo?group_id=${groupId}&chapter_id=${chapterId}`,
    { withCredentials: true }
  );
  return data;
}

export const getEditExercisePageInfo = async (groupId, exercise_id, chapter_id) => {
  let { data } = await axios.get(
    `${import.meta.env.VITE_BASE_URL}/index.php/supervisor_rest/getEditExercisePageInfo?group_id=${groupId}&exercise_id=${exercise_id}&chapter_id=${chapter_id}`,
    { withCredentials: true }
  );

  if (typeof data === 'string') {
    data = JSON.parse(stripBom(data));
  }

  return data;
}

export const getBreadCrumbs = async (params) => {
  const query = qs.stringify(params);
  const { data } = await axios.get(
    `${import.meta.env.VITE_BASE_URL}/index.php/common_rest/getBreadCrumbs?${query}`,
    { withCredentials: true }
  );
  return data;
}

export const createExercise = async (newExercise) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BASE_URL}/index.php/supervisor_rest/createExercise`,
    newExercise,
    { withCredentials: true }
  );
  return data;
}

export const getExerciseFormData = async (exerciseId) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BASE_URL}/index.php/supervisor_rest/getExerciseFormData?exercise_id=${exerciseId}`,
    { withCredentials: true }
  );
  return data;
};

export const updateExercise = async (updatedExercise) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BASE_URL}/index.php/supervisor_rest/updateExercise`,
    updatedExercise,
    { withCredentials: true }
  );
  return data;
};

export const logout = async () => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BASE_URL}/index.php/auth_rest/logout`, {},
    { withCredentials: true }
  );
  return data;
}

export const getChapterList = async (stu_id) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BASE_URL}/index.php/student_rest/getChapterList?stu_id=${stu_id}`,
    { withCredentials: true }
  );
  return data;
}

export const setChapterPermission = async (formData) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BASE_URL}/index.php/supervisor_rest/setChapterPermission`,
    formData,
    { withCredentials: true }
  );
  return data;
}

export const setAllowGroupLogin = async (body) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BASE_URL}/index.php/supervisor_rest/setAllowGroupLogin`,
    body,
    { withCredentials: true }
  );
  return data;
}

export const setAllowGroupUploadPicture = async (body) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BASE_URL}/index.php/supervisor_rest/setAllowGroupUploadPicture`,
    body,
    { withCredentials: true }
  );
  return data;
}

export const getStudentAssignedExercise = async (stu_id, chapter_id, item_id) => {
  let { data } = await axios.get(
    `${import.meta.env.VITE_BASE_URL}/index.php/student_rest/getStudentAssignedExercise?stu_id=${stu_id}&chapter_id=${chapter_id}&item_id=${item_id}`,
    { withCredentials: true }
  );

  if (typeof data === 'string') {
    data = JSON.parse(stripBom(data));
  }

  return data;
}

export const getStudentCardInfo = async (stu_id) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BASE_URL}/index.php/student_rest/getStudentCardInfo?stu_id=${stu_id}`,
    { withCredentials: true }
  );
  return data;
}

export const logoutAllStudentInGroup = async (group_id) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BASE_URL}/index.php/supervisor_rest/logoutAllStudentInGroup`, { group_id: group_id },
    { withCredentials: true }
  );
  return data;
}

export const getProfileFormData = async () => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BASE_URL}/index.php/common_rest/getProfileFormData`,
    { withCredentials: true }
  );
  return data;
}

export const getAllDepartment = async () => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BASE_URL}/index.php/common_rest/getAllDepartment`,
    { withCredentials: true }
  );
  return data;
}

export const updateProfile = async (formData) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BASE_URL}/index.php/common_rest/updateProfile`,
    formData,
    { withCredentials: true }
  );
  return data;
}

export const getExerciseTestcases = async (exercise_id) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BASE_URL}/index.php/supervisor_rest/getExerciseTestcases?exercise_id=${exercise_id}`,
    { withCredentials: true }
  );
  return data;
}

export const updateGroupAssignedChapterItem = async (formData) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BASE_URL}/index.php/supervisor_rest/updateGroupAssignedChapterItem`,
    formData,
    { withCredentials: true }
  );
  return data;
}

export const runTestcases = async (formData) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BASE_URL}/index.php/common_rest/runTestcases`,
    formData,
    { withCredentials: true }
  );
  return data;
}

export const sendRunTaskMessage = async (formData) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BASE_URL}/index.php/common_rest/sendRunTaskMessage`,
    formData,
    { withCredentials: true }
  );
  return data;
}