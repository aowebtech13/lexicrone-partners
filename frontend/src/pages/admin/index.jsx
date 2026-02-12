import React from 'react';
import SEO from '../../common/seo';
import Wrapper from '../../layout/wrapper';
import AdminRoute from '../../common/AdminRoute';
import AdminMain from '../../components/admin';

const AdminDashboardPage = () => {
    return (
        <AdminRoute>
            <Wrapper>
                <SEO pageTitle={"Admin Dashboard | Lexicrone Finance"} />
                <AdminMain />
            </Wrapper>
        </AdminRoute>
    );
};

export default AdminDashboardPage;
