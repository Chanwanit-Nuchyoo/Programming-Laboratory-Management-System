/* eslint-disable react/prop-types */
import ClassInfoBox from "@/components/InsGroupPage/ClassInfoBox"
import { FormControlLabel, Switch, Typography } from "@mui/material"
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { setAllowGroupLogin, setAllowGroupUploadPicture } from "@/utils/api";
import { useParams } from "react-router-dom"

const RightBox = ({ groupData }) => {
  const { groupId } = useParams();
  const queryClient = useQueryClient();

  const { mutate: mutateAllowLogin } = useMutation({
    mutationFn: setAllowGroupLogin,
    onSuccess: () => {
      queryClient.invalidateQueries(['groupData', groupId])
    },
    onError: (error) => {
      console.log(error)
    }
  })

  const { mutate: mutateAllowUploadPicture } = useMutation({
    mutationFn: setAllowGroupUploadPicture,
    onSuccess: () => {
      queryClient.invalidateQueries(['groupData', groupId])
    },
    onError: (error) => {
      console.log(error)
    }
  })

  const toggleAllowLogin = () => {
    mutateAllowLogin({
      group_id: groupId,
      allow_login: groupData?.allow_login === "yes" ? "no" : "yes"
    })
  }

  const toggleAllowUploadPicture = () => {
    mutateAllowUploadPicture({
      group_id: groupId,
      allow_upload_pic: groupData?.allow_upload_pic === "yes" ? "no" : "yes"
    })
  }

  return (
    <ClassInfoBox stackProps={{
      justifyContent: "center",
      alignItems: "start"
    }} >
      <FormControlLabel
        value="start"
        control={<Switch color="success" onClick={toggleAllowLogin} checked={groupData?.allow_login === "yes"} />}
        label={<Typography color={"primary"} fontWeight={600} >Allow Login</Typography>}
        labelPlacement="start"
      />
      <FormControlLabel
        value="start"
        control={<Switch color="success" onClick={toggleAllowUploadPicture} checked={groupData?.allow_upload_pic === "yes"} />}
        label={<Typography color={"primary"} fontWeight={600} >Upload picture</Typography>}
        labelPlacement="start"
      />
    </ClassInfoBox>
  )
}

export default RightBox