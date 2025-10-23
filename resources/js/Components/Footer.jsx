import React from 'react';

const Footer = () => {
    return (
        <>
            <footer className="footer mt-auto py-3 text-center">
                <div className="container">
                    <span className="text-muted">
                        Copyright © <span id="year">2025</span>{" "}. Made with{" "}
                        <span className="bi bi-heart-fill text-danger"></span> by{" "}
                        <a href="https://instagram.com/hiyussuf/" target="_blank" rel="noopener noreferrer" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="Lihat Profil Developer"
                            className='link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover text-decoration-underline'>
                            <span className="fw-medium text-primary">Sakudewa Tech</span>
                        </a>{" "}
                    </span>
                </div>
            </footer>

            <div className="modal fade" id="header-responsive-search" tabIndex="-1" aria-labelledby="header-responsive-search" aria-hidden="true">
                <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-body">
                            <div className="input-group">
                                <input
                                    type="text"
                                    className="form-control border-end-0"
                                    placeholder="Search Anything ..."
                                    aria-label="Search Anything ..."
                                    aria-describedby="button-addon2"
                                />
                                <button className="btn btn-primary" type="button" id="button-addon2">
                                    <i className="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Footer;
