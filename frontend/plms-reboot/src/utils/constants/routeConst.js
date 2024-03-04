import { USER_ROLES } from "@/utils/constants/common"

// Prefix for URLs based on user roles
export const PREFIX = {
  [USER_ROLES.SUPERVISOR]: "/ins",
  [USER_ROLES.STUDENT]: "/stu",
}

// URLs for Supervisor (INS) role
export const ABS_INS_URL = {
  "STATIC": {
    "MY_GROUPS": `${PREFIX[USER_ROLES.SUPERVISOR]}`,
    "AVAILABLE_GROUPS": `${PREFIX[USER_ROLES.SUPERVISOR]}/available-groups`,
    "INSTRUCTION": `${PREFIX[USER_ROLES.SUPERVISOR]}/instruction`,
    "EXAMINATION": `${PREFIX[USER_ROLES.SUPERVISOR]}/examination`,
    "FAQ": `${PREFIX[USER_ROLES.SUPERVISOR]}/faq`,
    "ADDGROUP": `${PREFIX[USER_ROLES.SUPERVISOR]}/addgroup`,
  },
  "DYNAMIC": {
    "GROUP": (groupId = ":groupId") =>
      `${PREFIX[USER_ROLES.SUPERVISOR]}/group/${groupId}`,
    "CHAPTER": (groupId = ":groupId", chapterId = ":chapterId") =>
      `${PREFIX[USER_ROLES.SUPERVISOR]}/group/${groupId}/chapter/${chapterId}`,
    "ADD_EXERCISE": (groupId = ":groupId", chapterId = ":chapterId", level = ":level") =>
      `${PREFIX[USER_ROLES.SUPERVISOR]}/group/${groupId}/chapter/${chapterId}/add-exercise/level/${level}/add-exercise`,
    "EDIT_EXERCISE": (groupId = ":groupId", chapterId = ":chapterId", level = ":level", exerciseId = ":exerciseId") =>
      `${PREFIX[USER_ROLES.SUPERVISOR]}/group/${groupId}/chapter/${chapterId}/level/${level}/edit_exercise/exercise/${exerciseId}`,
    "STUDENT_LIST": (groupId = ":groupId") =>
      `${PREFIX[USER_ROLES.SUPERVISOR]}/group/${groupId}/stu-list`,
    "ADD_STUDENT": (groupId = ":groupId") =>
      `${PREFIX[USER_ROLES.SUPERVISOR]}/group/${groupId}/add-stu`,
    "STUDENT_SCORE": (groupId = ":groupId", studentId = ":studentId") =>
      `${PREFIX[USER_ROLES.SUPERVISOR]}/group/${groupId}/score/stu/${studentId}`,
    "STUDENT_SUBMIT_HISTORY": (groupId = ":groupId", studentId = ":studentId", chapterId = ":chapterId", itemId = ":itemId") =>
      `${PREFIX[USER_ROLES.SUPERVISOR]}/group/${groupId}/sub-his/stu/${studentId}/chapter/${chapterId}/item/${itemId}`,
    "PROFILE": (userId = ":userId") =>
      `${PREFIX[USER_ROLES.SUPERVISOR]}/profile/${userId}`,
    "EDITGROUP": (groupId = ":groupId") =>
    `${PREFIX[USER_ROLES.SUPERVISOR]}/editgroup/${groupId}`,
  }
}

// URLs for Supervisor (INS) role
export const REL_INS_URL = {
  "STATIC": {
    "MY_GROUPS": ``,
    "AVAILABLE_GROUPS": `available-groups`,
    "INSTRUCTION": `instruction`,
    "EXAMINATION": `examination`,
    "FAQ": `faq`,
    "ADDGROUP": `addgroup`,
  },
  "DYNAMIC": {
    "GROUP": (groupId = ":groupId") =>
      `group/${groupId}`,
    "CHAPTER": (groupId = ":groupId", chapterId = ":chapterId") =>
      `group/${groupId}/chapter/${chapterId}`,
    "ADD_EXERCISE": (groupId = ":groupId", chapterId = ":chapterId", level = ":level") =>
      `group/${groupId}/chapter/${chapterId}/add-exercise/level/${level}/add-exercise`,
    "EDIT_EXERCISE": (groupId = ":groupId", chapterId = ":chapterId", level = ":level", exerciseId = ":exerciseId") =>
      `group/${groupId}/chapter/${chapterId}/level/${level}/edit_exercise/exercise/${exerciseId}`,
    "STUDENT_LIST": (groupId = ":groupId") =>
      `group/${groupId}/stu-list`,
    "ADD_STUDENT": (groupId = ":groupId") =>
      `group/${groupId}/add-stu`,
    "STUDENT_SCORE": (groupId = ":groupId", studentId = ":studentId") =>
      `group/${groupId}/score/stu/${studentId}`,
    "STUDENT_SUBMIT_HISTORY": (groupId = ":groupId", studentId = ":studentId", chapterId = ":chapterId", itemId = ":itemId") =>
      `group/${groupId}/sub-his/stu/${studentId}/chapter/${chapterId}/item/${itemId}`,
    "PROFILE": (userId = ":userId") =>
      `profile/${userId}`,
      "EDITGROUP": (groupId = ":groupId") =>
      `editgroup/${groupId}`,
  }
}

// URLs for Student (STU) role
export const ABS_STU_URL = {
  "STATIC": {
    "HOME": `${PREFIX[USER_ROLES.STUDENT]}`,
    "EXERCISE_LIST": `${PREFIX[USER_ROLES.STUDENT]}/exercise-list`,
    "INSTRUCTION": `${PREFIX[USER_ROLES.STUDENT]}/instruction`,
    "EXAMINATION": `${PREFIX[USER_ROLES.STUDENT]}/examination`,
    "FAQ": `${PREFIX[USER_ROLES.STUDENT]}/faq`,
  },
  "DYNAMIC": {
    "EXERCISE": (group_id = ":groupId", chapterId = ':chapterId', itemId = ":itemId") =>
      `${PREFIX[USER_ROLES.STUDENT]}/group/${group_id}/chapter/${chapterId}/item/${itemId}`,
    "PROFILE": (userId = ":userId") =>
      `${PREFIX[USER_ROLES.STUDENT]}/profile/${userId}`,
  }
}

export const REL_STU_URL = {
  "STATIC": {
    "HOME": ``,
    "EXERCISE_LIST": `exercise-list`,
    "INSTRUCTION": `instruction`,
    "EXAMINATION": `examination`,
    "FAQ": `faq`,
  },
  "DYNAMIC": {
    "EXERCISE": (group_id = ":groupId", chapterId = ':chapterId', itemId = ":itemId") =>
      `group/${group_id}/chapter/${chapterId}/item/${itemId}`,
    "PROFILE": (userId = ":userId") =>
      `profile/${userId}`,
  }
}

// Common URLs
export const COMMON_URL = {
  STATIC: {
    "SIGNIN": "/signin",
  },
  DYNAMIC: {
  }
}