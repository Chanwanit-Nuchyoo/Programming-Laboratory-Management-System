/* eslint-disable react/prop-types */
import React from 'react';
import ClassInfoBox from "@/components/InsGroupPage/ClassInfoBox";
import { Typography } from "@mui/material";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { setAllowGroupLogin, setAllowGroupUploadPicture } from "@/utils/api";
import { useParams } from "react-router-dom";
import allowUpload from '@/assets/images/allowupload.svg';
import allowLogin from '@/assets/images/allowlogin.svg';
import ToggleSwitch from './ToggleSwitch';  // Import the ToggleSwitch component

const RightBox = ({ groupData }) => {
  const { groupId } = useParams();
  const queryClient = useQueryClient();

  const { mutate: mutateAllowLogin } = useMutation({
    mutationFn: setAllowGroupLogin,
    onSuccess: () => {
      queryClient.invalidateQueries(['groupData', groupId])
    },
    // Adding optimistic update
    onMutate: async (variables) => {
      const snapshot = queryClient.getQueryData(['groupData', groupId]);
      // Optimistically update
      queryClient.setQueryData(['groupData', groupId],  
      {
        ...snapshot,
        allow_login: snapshot.allow_login === "yes" ? "no" : "yes",
      });
      // Return a context object with the snapshot for backup plan
      return { snapshot };
    },
    onError: (error, variables, context) => {
      console.log(error);
      queryClient.setQueryData(['groupData', groupId], () =>context?.snapshot);
    },
    onSettled: () => {
      queryClient.invalidateQueries(['groupData', groupId]);
    },
  })

  const { mutate: mutateAllowUploadPicture } = useMutation({
    mutationFn: setAllowGroupUploadPicture,
    onSuccess: () => {
      queryClient.invalidateQueries(['groupData', groupId])
    },
    // Adding optimistic update
    onMutate: async (variables) => {
      const snapshot = queryClient.getQueryData(['groupData', groupId]);
      // Optimistically update
      queryClient.setQueryData(['groupData', groupId],  
      {
        ...snapshot,
        allow_upload_pic: snapshot.allow_upload_pic === "yes" ? "no" : "yes",
      });
      // Return a context object with the snapshot for backup plan
      return { snapshot };
    },
    onError: (error, variables, context) => {
      console.log(error);
      queryClient.setQueryData(['groupData', groupId], () =>context?.snapshot);
    },
    onSettled: () => {
      queryClient.invalidateQueries(['groupData', groupId]);
    },
  })

  const toggleAllowLogin = () => {
    mutateAllowLogin({
      group_id: groupId,
      allow_login: groupData?.allow_login === "yes" ? "no" : "yes"
    });
  };

  const toggleAllowUploadPicture = () => {
    mutateAllowUploadPicture({
      group_id: groupId,
      allow_upload_pic: groupData?.allow_upload_pic === "yes" ? "no" : "yes"
    });
  };

  return (
    <ClassInfoBox 
      stackProps={{ display: 'flex', flexDirection: 'row' }}
    >
      <div style={{ flex: 1, display: 'flex', flexDirection: 'column', alignItems: 'center', borderRight: '1px solid rgba(255, 255, 255, 0.20)' }}>
        <img src={allowLogin} style={{ marginTop: '10px', marginBottom: '10px' }} alt="Allow Login" />
        <Typography color={"primary"} fontWeight={600} style={{ marginBottom: '34px' }}>Allow log in</Typography>
        <ToggleSwitch isChecked={groupData?.allow_login === "yes"} onToggle={toggleAllowLogin} />
      </div>
  
      <div style={{ flex: 1, display: 'flex', flexDirection: 'column', alignItems: 'center' }}>
        <img src={allowUpload} style={{ marginBottom: '10px' }} alt="Allow Upload" />
        <Typography color={"primary"} fontWeight={600} style={{ marginBottom: '10px' }}>Allow upload <br />profile picture</Typography>
        <ToggleSwitch isChecked={groupData?.allow_upload_pic === "yes"} onToggle={toggleAllowUploadPicture} />
      </div>
    </ClassInfoBox>
  );
  
};

export default RightBox