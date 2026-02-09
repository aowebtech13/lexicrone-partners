import React from "react";
import EmailIcon from "../svg/email";

const HeroForm = () => {
  return (
    <>
      <form onSubmit={(e) => e.preventDefault()}>
        <div className="p-relative">
          <input type="number" placeholder=" Enter Phone Number" />
         {/* email icon */}
         <EmailIcon />
        </div>
        <button className="tp-btn tp-btn-hover alt-color-black">
          <span>Talk to an Agent</span>
          <b></b>
        </button>
      </form>
    </>
  );
};

export default HeroForm;
