
import React from 'react';
import { Container, Stack} from "@mui/material";
// components
import MyBreadCrumbs from '@/components/_shared/MyBreadCrumbs';
import Header from '@/components/_shared/Header';
import slideShow from '@/assets/images/slideshowicon.svg';
import AddGroupForm from '../components/AddGroup/AddGroupForm';

const AddGroup = () => { 
        const items = [{ label: 'My Groups', href: '/ins' }];
        const defaultValue ={
            "group_id":"",
            "group_name":"",
            "group_no": "",
            "department": "",
            // "lecturer": "",
            "day_of_week":"",
            "time_start":"",
            "time_end":"",
            "year":"",
            "semester":""
        }
        return (
            <Container>
                <Stack spacing="20px">
                    <MyBreadCrumbs items={items} />
                        <Header logoSrc={slideShow} title="AddGroup"/>

                        <AddGroupForm defaultValue = {defaultValue}/>
                </Stack>
                
            </Container>
        )
}
export default AddGroup
