import Link from 'next/link';
import Image from 'next/image';
import React, { useState } from 'react';
import api from '@/src/utils/api';
import { toast } from 'react-toastify';

// account images
import account_img_1 from "../../../../public/assets/img/account/account-bg.png"
import account_img_2 from "../../../../public/assets/img/account/acc-main.png"
import account_img_3 from "../../../../public/assets/img/account/ac-author.png"
import account_img_4 from "../../../../public/assets/img/account/ac-shape-1.png"
import account_img_5 from "../../../../public/assets/img/account/ac-shape-2.png"

const account_shape = [
    {
        id: 1,
        cls: "bg",
        img: account_img_1 
    },
    {
        id: 2,
        cls: "main-img",
        img: account_img_2 
    },
    {
        id: 3,
        cls: "author",
        img: account_img_3 
    },
    {
        id: 4,
        cls: "shape-1",
        img: account_img_4
    },
    {
        id: 5,
        cls: "shape-2",
        img: account_img_5
    },
];

const ForgotPasswordArea = () => {
    const [email, setEmail] = useState('');
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            await api.post('forgot-password', { email });
            toast.success("Password reset link sent to your email!");
        } catch (error) {
            console.error(error);
            const errorMessage = error.response?.data?.message || "Something went wrong. Please try again.";
            toast.error(errorMessage);
        } finally {
            setLoading(false);
        }
    };

    return (
        <>
            <div className="signin-banner-area signin-banner-main-wrap d-flex align-items-center">
                <div className="signin-banner-left-box d-none d-lg-block p-relative" style={{ backgroundColor: '#F1EFF4', height: '100vh', display: 'flex', alignItems: 'center', justifyContent: 'center', overflow: 'hidden' }}>
                    <div className="tp-account-thumb-wrapper p-relative text-center">
                        {account_shape.map((item, i) => (
                            <div key={i} className={`tp-account-${item.cls}`}>
                                <Image src={item.img} alt="theme-pure" />
                            </div>
                        ))}
                    </div>
                </div>
                <div className="signin-banner-from d-flex justify-content-center align-items-center" style={{ flex: '1' }}>
                    <div className="signin-banner-from-wrap">
                        <div className="signin-banner-title-box">
                            <h4 className="signin-banner-from-title">Forgot Password</h4>
                            <p className="mb-30">Enter your email address to receive a reset link.</p>
                        </div>
                        <div className="signin-banner-from-box">
                            <form onSubmit={handleSubmit}>
                                <div className="postbox__comment-input mb-30">
                                    <input 
                                        type="email" 
                                        className="inputText"
                                        placeholder="Your Email"
                                        value={email}
                                        onChange={(e) => setEmail(e.target.value)}
                                        required
                                    />
                                </div>
                                <div className="signin-banner-from-btn mb-20">
                                    <button type="submit" className="signin-btn w-100" disabled={loading}>
                                        {loading ? 'Sending...' : 'Send Reset Link'}
                                    </button>
                                </div>
                            </form>
                            <div className="signin-banner-from-register text-center mt-20">
                                <Link href="/sign-in">
                                    Remember your password? <span>Sign In</span>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default ForgotPasswordArea;
