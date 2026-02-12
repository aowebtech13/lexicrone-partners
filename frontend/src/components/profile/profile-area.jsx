import React, { useEffect, useState, useRef } from 'react';
import api from '@/src/utils/api';
import { toast } from 'react-toastify';

const ProfileArea = () => {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);
    const [updating, setUpdating] = useState(false);
    const [name, setName] = useState('');
    const [phone, setPhone] = useState('');
    const [avatarFile, setAvatarFile] = useState(null);
    const [avatarPreview, setAvatarPreview] = useState(null);
    const fileInputRef = useRef(null);

    const fetchProfile = async () => {
        try {
            const { data } = await api.get('profile');
            setUser(data.user);
            setName(data.user.name);
            setPhone(data.user.phone || '');
            if (data.user.avatar_url) {
                setAvatarPreview(data.user.avatar_url);
            }
        } catch (error) {
            console.error("Error fetching profile:", error);
            toast.error("Failed to load profile");
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchProfile();
    }, []);

    const handleFileChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setAvatarFile(file);
            const reader = new FileReader();
            reader.onloadend = () => {
                setAvatarPreview(reader.result);
            };
            reader.readAsDataURL(file);
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setUpdating(true);

        const formData = new FormData();
        formData.append('name', name);
        formData.append('phone', phone);
        if (avatarFile) {
            formData.append('avatar', avatarFile);
        }

        try {
            const { data } = await api.post('profile', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });
            setUser(data.user);
            toast.success("Profile updated successfully!");
        } catch (error) {
            console.error("Error updating profile:", error);
            toast.error(error.response?.data?.message || "Failed to update profile");
        } finally {
            setUpdating(false);
        }
    };

    if (loading) return (
        <div className="d-flex justify-content-center align-items-center min-vh-60">
            <div className="spinner-border text-primary" role="status">
                <span className="visually-hidden">Loading...</span>
            </div>
        </div>
    );

    return (
        <div className="profile-area py-5 bg-light">
            <div className="container">
                <div className="row g-4 justify-content-center">
                    
                    {/* Sidebar: Profile Card */}
                    <div className="col-lg-4">
                        <div className="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style={{ top: '100px', zIndex: 1 }}>
                            {/* Profile Header Background */}
                            <div className="bg-primary position-relative" style={{ height: '120px', background: 'linear-gradient(135deg, #0d6efd 0%, #6610f2 100%)' }}>
                                <div className="position-absolute top-0 end-0 m-3 badge rounded-pill bg-white bg-opacity-25 border border-white border-opacity-25 text-white text-uppercase tracking-wider" style={{ fontSize: '10px' }}>
                                    {user?.role || 'Investor'}
                                </div>
                            </div>
                            
                            {/* Profile Info */}
                            <div className="card-body px-4 pb-4 text-center mt-n5">
                                <div className="position-relative d-inline-block mb-3" style={{ marginTop: '-60px' }}>
                                    <div className="rounded-circle border border-4 border-white shadow bg-light overflow-hidden position-relative" style={{ width: '120px', height: '120px' }}>
                                        {avatarPreview ? (
                                            <img src={avatarPreview} alt="Profile" className="w-100 h-100 object-fit-cover" />
                                        ) : (
                                            <div className="d-flex align-items-center justify-content-center w-100 h-100 bg-secondary-subtle text-secondary fs-1 fw-bold">
                                                {user?.name?.charAt(0)}
                                            </div>
                                        )}
                                    </div>
                                    
                                    <button 
                                        type="button"
                                        onClick={() => fileInputRef.current.click()}
                                        className="btn btn-white btn-sm rounded-circle position-absolute bottom-0 end-0 shadow-sm border p-0 d-flex align-items-center justify-content-center"
                                        style={{ width: '32px', height: '32px' }}
                                    >
                                        <i className="fa-solid fa-camera text-primary" style={{ fontSize: '12px' }}></i>
                                    </button>
                                    <input 
                                        type="file" 
                                        ref={fileInputRef} 
                                        onChange={handleFileChange} 
                                        className="d-none" 
                                        accept="image/*"
                                    />
                                </div>

                                <h4 className="fw-bold text-dark mb-1">{user?.name}</h4>
                                <p className="text-muted small mb-4">
                                    <i className="fa-solid fa-envelope me-2 opacity-50"></i>
                                    {user?.email}
                                </p>
                                
                                <div className="row g-2 mb-4">
                                    <div className="col-6">
                                        <div className="p-3 rounded-3 bg-light border border-light-subtle">
                                            <small className="d-block text-muted text-uppercase fw-bold ls-1 mb-1" style={{ fontSize: '10px' }}>Balance</small>
                                            <span className="h6 fw-bold text-primary mb-0">${Number(user?.balance || 0).toLocaleString()}</span>
                                        </div>
                                    </div>
                                    <div className="col-6">
                                        <div className="p-3 rounded-3 bg-light border border-light-subtle">
                                            <small className="d-block text-muted text-uppercase fw-bold ls-1 mb-1" style={{ fontSize: '10px' }}>Joined</small>
                                            <span className="h6 fw-bold text-dark mb-0">{user?.created_at ? new Date(user.created_at).getFullYear() : '2024'}</span>
                                        </div>
                                    </div>
                                </div>

                                <div className="d-grid gap-2">
                                    <div className="d-flex align-items-center gap-3 p-3 rounded-3 bg-success-subtle text-success border border-success-subtle text-start">
                                        <div className="flex-shrink-0 bg-white rounded-2 shadow-sm d-flex align-items-center justify-content-center" style={{ width: '32px', height: '32px' }}>
                                            <i className="fa-solid fa-shield-check text-success"></i>
                                        </div>
                                        <div>
                                            <p className="small fw-bold mb-0">Identity Verified</p>
                                            <p className="mb-0 opacity-75" style={{ fontSize: '10px' }}>Secured with SSL</p>
                                        </div>
                                    </div>
                                    <button className="btn btn-light btn-sm fw-bold py-2 border-0">
                                        <i className="fa-solid fa-gear me-2 opacity-50"></i>
                                        Account Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Main Content: Form */}
                    <div className="col-lg-8">
                        <div className="card border-0 shadow-sm rounded-4">
                            <div className="card-body p-4 p-md-5">
                                <div className="d-flex align-items-center gap-3 mb-4">
                                    <div className="bg-primary-subtle rounded-3 d-flex align-items-center justify-content-center text-primary shadow-sm" style={{ width: '56px', height: '56px' }}>
                                        <i className="fa-solid fa-user-gear fs-4"></i>
                                    </div>
                                    <div>
                                        <h4 className="fw-bold text-dark mb-0">Personal Information</h4>
                                        <p className="text-muted small mb-0">Update your personal details and public profile</p>
                                    </div>
                                </div>

                                <form onSubmit={handleSubmit}>
                                    <div className="row g-4 mb-4">
                                        <div className="col-md-6">
                                            <label className="form-label fw-bold text-dark small ms-1">Full Name</label>
                                            <div className="input-group">
                                                <span className="input-group-text bg-light border-0 px-3">
                                                    <i className="fa-solid fa-user text-muted small"></i>
                                                </span>
                                                <input 
                                                    type="text" 
                                                    value={name}
                                                    onChange={(e) => setName(e.target.value)}
                                                    className="form-control bg-light border-0 py-2 py-md-3" 
                                                    placeholder="John Doe"
                                                    required
                                                />
                                            </div>
                                        </div>

                                        <div className="col-md-6">
                                            <label className="form-label fw-bold text-dark small ms-1">Phone Number</label>
                                            <div className="input-group">
                                                <span className="input-group-text bg-light border-0 px-3">
                                                    <i className="fa-solid fa-phone text-muted small"></i>
                                                </span>
                                                <input 
                                                    type="text" 
                                                    value={phone}
                                                    onChange={(e) => setPhone(e.target.value)}
                                                    className="form-control bg-light border-0 py-2 py-md-3" 
                                                    placeholder="+1 (555) 000-0000"
                                                />
                                            </div>
                                        </div>

                                        <div className="col-12">
                                            <div className="d-flex align-items-center justify-content-between mb-2 ms-1">
                                                <label className="form-label fw-bold text-dark small mb-0">Email Address</label>
                                                <span className="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle py-1 px-2" style={{ fontSize: '9px' }}>
                                                    <i className="fa-solid fa-lock me-1"></i> VERIFIED
                                                </span>
                                            </div>
                                            <div className="input-group opacity-75">
                                                <span className="input-group-text bg-light border-0 px-3">
                                                    <i className="fa-solid fa-envelope text-muted small"></i>
                                                </span>
                                                <input 
                                                    type="email" 
                                                    value={user?.email || ''}
                                                    className="form-control bg-secondary-subtle border-0 py-2 py-md-3" 
                                                    disabled
                                                />
                                            </div>
                                            <p className="text-muted italic small mt-2 ms-1" style={{ fontSize: '11px' }}>
                                                Email address is locked for security purposes.
                                            </p>
                                        </div>
                                    </div>

                                    <div className="d-flex flex-column flex-sm-row align-items-center gap-3 pt-4 border-top">
                                        <button 
                                            type="submit" 
                                            disabled={updating}
                                            className="btn btn-primary px-5 py-3 rounded-3 fw-bold shadow-sm d-flex align-items-center gap-2"
                                        >
                                            {updating ? (
                                                <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            ) : (
                                                <>
                                                    Save Changes
                                                    <i className="fa-solid fa-circle-check"></i>
                                                </>
                                            )}
                                        </button>
                                        
                                        <button 
                                            type="button"
                                            onClick={() => fetchProfile()}
                                            className="btn btn-light px-4 py-3 rounded-3 fw-bold"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {/* Additional Info Cards */}
                        <div className="row g-4 mt-2">
                            <div className="col-md-6">
                                <div className="card border-0 shadow-sm rounded-4 h-100 p-3">
                                    <div className="card-body">
                                        <div className="bg-warning-subtle rounded-3 d-flex align-items-center justify-content-center text-warning mb-3" style={{ width: '48px', height: '48px' }}>
                                            <i className="fa-solid fa-key fs-5"></i>
                                        </div>
                                        <h6 className="fw-bold text-dark mb-1">Security Settings</h6>
                                        <p className="text-muted small mb-3">Manage your password and 2FA authentication.</p>
                                        <a href="#" className="text-primary text-decoration-none small fw-bold d-flex align-items-center gap-1">
                                            Update Security <i className="fa-solid fa-chevron-right" style={{ fontSize: '10px' }}></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div className="col-md-6">
                                <div className="card border-0 shadow-sm rounded-4 h-100 p-3">
                                    <div className="card-body">
                                        <div className="bg-info-subtle rounded-3 d-flex align-items-center justify-content-center text-info mb-3" style={{ width: '48px', height: '48px' }}>
                                            <i className="fa-solid fa-clock-rotate-left fs-5"></i>
                                        </div>
                                        <h6 className="fw-bold text-dark mb-1">Login Activity</h6>
                                        <p className="text-muted small mb-3">Check where and when you've been logged in.</p>
                                        <a href="#" className="text-primary text-decoration-none small fw-bold d-flex align-items-center gap-1">
                                            View Activity <i className="fa-solid fa-chevron-right" style={{ fontSize: '10px' }}></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default ProfileArea;
