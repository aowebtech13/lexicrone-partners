import React from 'react';
import SEO from '../common/seo';
import DashboardMain from '../components/dashboard';
import Wrapper from '../layout/wrapper';

const DashboardPage = () => {
    return (
        <Wrapper>
            <SEO pageTitle={"Dashboard | Lexicrone Finance"} />
            <DashboardMain />
        </Wrapper>
    );
};

export default DashboardPage;
