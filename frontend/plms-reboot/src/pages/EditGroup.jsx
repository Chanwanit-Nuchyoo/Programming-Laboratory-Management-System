
import React from 'react';
import { Container, Stack} from "@mui/material";
import { useParams } from "react-router-dom"

// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs';
import Header from '@/components/_shared/Header';
import slideShow from '@/assets/images/slideshowicon.svg';
import EditGroupForm from '../components/EditGroup/EditGroupForm';
import useClassScheduleQuery from "@/hooks/useClassScheduleQuery";


const EditGroup = () => { 
        const { groupId } = useParams();
        const { data: classScheduleData, isLoading: isClassScheduleLoading } = useClassScheduleQuery(groupId);
        const items = [{ label: 'My Groups', href: '/ins' }];
        const form = isClassScheduleLoading ? '' : {
            "group_id": classScheduleData.payload.group_id,
            "group_name": classScheduleData.payload.group_name,
            "group_no": classScheduleData.payload.group_no,
            "department": classScheduleData.payload.department,
            // "lecturer": classScheduleData.payload.group_id,
            "day_of_week": classScheduleData.payload.day_of_week,
            "time_start": classScheduleData.payload.time_start,
            "time_end": classScheduleData.payload.time_end,
            "year": classScheduleData.payload.year,
            "semester": classScheduleData.payload.semester,
        };
        return (
            <Container>
                <Stack spacing="20px">
                    <MyBreadCrumbs items={items} />
                        <Header logoSrc={slideShow} title="EditGroup"/>

                        {isClassScheduleLoading ? 'Loading...' : <EditGroupForm form = {form}/>}
                </Stack>
                
            </Container>
        )
}
export default EditGroup
