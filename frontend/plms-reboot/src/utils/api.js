import axios from "axios"
import stripBom from 'strip-bom';
import qs from 'qs'

export const getLabChapterInfo = async (groupId, labNo) => {
  const { data } = await axios.get(`${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/getLabChapterInfo?group_id=${groupId}&lab_no=${labNo}`, { withCredentials: true })
  return data.payload
}

export const getAllAvailableGroups = async (queryString) => {
  const { data } = await axios.get(`${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/getAllAvailableGroups?${queryString}`, { withCredentials: true });
  return data.payload
}

export const getGroupListById = async () => {
  const { data } = await axios.get(`${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/getGroupListById?year=${import.meta.env.VITE_YEAR}`, { withCredentials: true });
  return data.payload.group_list
}

export const getStudentListInGroupWithLabScore = async (groupId) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/getStudentListInGroupWithLabScore?group_id=${groupId}`,
    { withCredentials: true }
  );
  return data.payload;
}

export const getAddExercisePageInfo = async (groupId, chapterId) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/getAddExercisePageInfo?group_id=${groupId}&chapter_id=${chapterId}`,
    { withCredentials: true }
  );
  return data;
}

export const getEditExercisePageInfo = async (groupId, exercise_id, chapter_id) => {
  let { data } = await axios.get(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/getEditExercisePageInfo?group_id=${groupId}&exercise_id=${exercise_id}&chapter_id=${chapter_id}`,
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
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/common_rest/getBreadCrumbs?${query}`,
    { withCredentials: true }
  );
  return data;
}

export const createExercise = async (newExercise) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/createExercise`,
    newExercise,
    { withCredentials: true }
  );
  return data;
}

export const getExerciseFormData = async (exerciseId) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/getExerciseFormData?exercise_id=${exerciseId}`,
    { withCredentials: true }
  );
  return data;
};

export const updateExercise = async (updatedExercise) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/updateExercise`,
    updatedExercise,
    { withCredentials: true }
  );
  return data;
};

export const logout = async () => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/auth_rest/logout`, {},
    { withCredentials: true }
  );
  return data;
}

export const getChapterList = async (stu_id) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/student_rest/getChapterList?stu_id=${stu_id}`,
    { withCredentials: true }
  );
  return data;
}

export const setChapterPermission = async (formData) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/setChapterPermission`,
    formData,
    { withCredentials: true }
  );
  return data;
}

export const setAllowGroupLogin = async (body) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/setAllowGroupLogin`,
    body,
    { withCredentials: true }
  );
  return data;
}

export const setAllowGroupUploadPicture = async (body) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/setAllowGroupUploadPicture`,
    body,
    { withCredentials: true }
  );
  return data;
}

export const getStudentAssignedExercise = async (stu_id, chapter_id, item_id) => {
  let { data } = await axios.get(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/student_rest/getStudentAssignedExercise?stu_id=${stu_id}&chapter_id=${chapter_id}&item_id=${item_id}`,
    { withCredentials: true }
  ).catch((error) => {
    throw new Error(error.response.data.message);
  });

  if (typeof data === 'string') {
    data = JSON.parse(stripBom(data));
  }

  return data;
}

export const getStudentCardInfo = async (stu_id) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/student_rest/getStudentCardInfo?stu_id=${stu_id}`,
    { withCredentials: true }
  );
  return data;
}

export const logoutAllStudentInGroup = async (group_id) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/logoutAllStudentInGroup`, { group_id: group_id },
    { withCredentials: true }
  );
  return data;
}

export const getProfileFormData = async () => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/common_rest/getProfileFormData`,
    { withCredentials: true }
  );
  return data;
}

export const getAllDepartment = async () => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/common_rest/getAllDepartment`,
    { withCredentials: true }
  );
  return data;
}

export const getAllLabStaff = async () => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/getAllLabStaff`,
    { withCredentials: true }
  );
  return data;
}

export const updateProfile = async (formData) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/common_rest/updateProfile`,
    formData,
    { withCredentials: true }
  );
  return data;
}

export const getExerciseTestcases = async (exercise_id) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/getExerciseTestcases?exercise_id=${exercise_id}`,
    { withCredentials: true }
  );
  return data;
}

export const updateGroupAssignedChapterItem = async (formData) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/updateGroupAssignedChapterItem`,
    formData,
    { withCredentials: true }
  );
  return data;
}

export const updateAllGroupAssignedChapterItem = async (formData) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/updateAllGroupAssignedChapterItem`,
    formData,
    { withCredentials: true }
  );
  return data;
}

export const saveExerciseTestcase = async (formData) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/saveExerciseTestcase`,
    formData,
    { withCredentials: true }
  );
  return data;
}

export const getKeywordList = async (formdata) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/common_rest/getKeywordList`,
    formdata,
    { withCredentials: true }
  );
  return data;
}

export const getStudentSubmissionList = async ($stu_id, $chapter_id, $item_id) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/common_rest/getStudentSubmissionList?stu_id=${$stu_id}&chapter_id=${$chapter_id}&item_id=${$item_id}`,
    { withCredentials: true }
  );
  return data;
}

export const studentExerciseSubmit = async (formData) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/student_rest/studentExerciseSubmit`,
    formData,
    { withCredentials: true }
  );
  return data;
}

export const checkKeyword = async (formData) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/common_rest/checkKeyword`,
    formData,
    { withCredentials: true }
  );
  return data;
}

export const studentInfoCard = async (stu_id) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/studentInfoCard?stu_id=${stu_id}`,
    { withCredentials: true }
  );
  return data;
}

export const resetStudentPassword = async (formData) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/resetStudentPassword`,
    formData,
    { withCredentials: true }
  );
  return data;
}

export const getAssignedStudentExercise = async (stu_id, chapter_id, item_id) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/getAssignedStudentExercise?stu_id=${stu_id}&chapter_id=${chapter_id}&item_id=${item_id}`,
    { withCredentials: true }
  );
  return data;
}

export const addStudent = async (formData) => {
  const { data } = await axios.post(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/addStudent`,
    formData,
    { withCredentials: true }
  );
  return data;
}

export const getChapterPermission = async (group_id) => {
  const { data } = await axios.get(
    `${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/student_rest/getChapterPermission?group_id=${group_id}`,
    { withCredentials: true }
  );
  return data;
}

export const getGroupDataById = async (groupId) => {
  const res = await axios.get(`${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/getGroupDataById?group_id=${groupId}`,
    { withCredentials: true }
  )
  return res.data.payload.class_schedule;
}

export const getGroupChapterPermission = async (groupId) => {
  const res = await axios.get(`${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/getGroupChapterPermission?group_id=${groupId}`, { withCredentials: true })
  return res.data;
}

export const deleteStudent = async (formData) => {
  const res = await axios.post(`${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/deleteStudent`,
    formData,
    { withCredentials: true }
  )
  return res.data;
}

export const setStudentCanSubmit = async (formData) => {
  const res = await axios.post(`${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/setStudentCanSubmit`,
    formData,
    { withCredentials: true }
  )
  return res.data;
}

export const deleteExercise = async (formData) => {
  const res = await axios.post(`${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/deleteExercise`,
    formData,
    { withCredentials: true }
  )

  return res.data;
}

export const cancleStudentSubmission = async (formData) => {
  const res = await axios.post(`${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/cancleStudentSubmission`,
    formData,
    { withCredentials: true }
  )
  return res.data;
}

export const createGroup = async (formData) => {
  const res = await axios.post(`${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/createGroup`,
    formData,
    { withCredentials: true }
  )
  return res.data;
}

export const editGroup = async (formData) => {
  const res = await axios.post(`${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/editGroup`,
    formData,
    { withCredentials: true }
  )
  return res.data;
}

export const getClassSchedule = async (group_id) => {
  const { data } = await axios.get(`${import.meta.env.VITE_BACKEND_BASE_URL}/index.php/supervisor_rest/getClassSchedule?group_id=${group_id}`,
    { withCredentials: true }
  )
  return data;
}

