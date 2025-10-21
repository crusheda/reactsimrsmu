import React from 'react';

const Footer = () => {
    return (
        <>
            <footer className="footer mt-auto py-3 text-center">
                <div className="container">
                    <span className="text-muted">
                        Copyright © <span id="year">2025</span>{" "}
                        <a href="#" className="text-dark fw-medium">Vyzor</a>. Designed with{" "}
                        <span className="bi bi-heart-fill text-danger"></span> by{" "}
                        <a href="https://spruko.com/" target="_blank" rel="noopener noreferrer">
                            <span className="fw-medium text-primary">Spruko</span>
                        </a>{" "}
                        All rights reserved
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
