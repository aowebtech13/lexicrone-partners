import React from "react";
import SEO from "../common/seo";
import Integrations from "../components/integrations";
import Wrapper from "../layout/wrapper";

const index = () => {
  return (
    <Wrapper>
      <SEO pageTitle={"Lexicrone| The future of Trading is here"} />
      <Integrations />
    </Wrapper>
  );
};

export default index;
