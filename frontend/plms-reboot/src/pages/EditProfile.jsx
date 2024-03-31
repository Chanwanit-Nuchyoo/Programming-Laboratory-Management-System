/* eslint-disable react/prop-types */
import { Box, Container, Stack } from "@mui/material";
import PersonIcon from '@mui/icons-material/Person';
import Header from '@/components/_shared/Header';
import { useEffect } from "react";
import { useQuery } from "@tanstack/react-query";
import { getProfileFormData } from '@/utils/api';
import { useAtom } from "jotai";
import { userAtom } from "@/store/store";
import { useSetAtom } from "jotai";
import { sidebarSelectedAtom } from "@/store/store";
import EditProfileForm from "@/components/EditProfilePage/EditProfileForm";
import moment from "moment";

const defaultValue = {
  "avatar": "",
  "firstname": "",
  "lastName": "",
  "nickname": "",
  "dob": null,
  "gender": "",
  "department": "",
  "email": "",
  "tel": "",
}

const EditProfile = () => {
  const [user] = useAtom(userAtom);
  const setSelected = useSetAtom(sidebarSelectedAtom);

  useEffect(() => {
    setSelected('');
  }, []);

  const { data: formData, isLoading } = useQuery({
    queryKey: ['profileFormData', user.id],
    queryFn: () => getProfileFormData(),
    staleTime: Infinity,
  })

  const form = isLoading ? defaultValue : {
    "avatar": formData.avatar || "",
    "firstname": formData.firstname || "",
    "lastName": formData.lastname || "",
    "nickname": formData.nickname || "",
    "dob": formData.dob === '0000-00-00' || formData.dob === null ? null : moment(formData.dob),
    "gender": formData.gender || "",
    "department": formData.department || "",
    "email": formData.email || "",
    "tel": formData.tel || "",
  }

  return (
    <Box>
      <Container >
        <Stack spacing={"20px"}>
          {/* Breadcrumbs and Header components */}
          <Header logoIcon={<PersonIcon sx={{ fontSize: "30px" }} />} title="Edit Profile" />

          <EditProfileForm user={user} formData={form} userId={user.id} allowUploadPic={user.role === "supervisor" || (!isLoading && formData.allow_upload_pic === "yes")} />

        </Stack>
      </Container>
    </Box >
  );
};

export default EditProfile;
