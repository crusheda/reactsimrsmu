import { useState, useEffect, useRef } from 'react';
import { Head, useForm } from '@inertiajs/react';

export default function Login() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        password: '',
        captcha: '',
        remember: false,
    });

    const [showPassword, setShowPassword] = useState(false);
    const [captchaImage, setCaptchaImage] = useState('/captcha/math');
    const [spinning, setSpinning] = useState(false);
    const [progress, setProgress] = useState(0);
    const [theme, setTheme] = useState(() => localStorage.getItem('theme') || 'light');

    const intervalRef = useRef(null);
    const secondsRef = useRef(0);
    const startRef = useRef(Date.now());

    // 🔹 Ambil tema dari localStorage
    useEffect(() => {
        const savedTheme = localStorage.getItem('theme') || 'light';
        setTheme(savedTheme);
    }, []);

    const logoTextSrc =
        theme === 'dark'
            ? '/react/images/logo/logo_full_text_dark.png'
            : '/react/images/logo/logo_full_text_light.png';

    const logoSrc =
        theme === 'dark'
            ? '/react/images/logo/onlylogo/logo_dark_verysmall.png'
            : '/react/images/logo/onlylogo/logo_light_verysmall.png';

    const reloadCaptcha = () => {
        setSpinning(true); // mulai putar
        setCaptchaImage(`/captcha/math?${Date.now()}`); // update URL captcha
        secondsRef.current = 0;  // reset detik (bisa dihapus juga kalau tidak dipakai)
        startRef.current = Date.now(); // reset timer supaya progress mulai dari 0
        setProgress(0);
    };

    const handleCaptchaLoad = () => {
        setSpinning(false); // hentikan animasi setelah gambar selesai load
    };

    const submit = (e) => {
        e.preventDefault();
        post(route('login'), {
            onFinish: () => reset('password', 'captcha'),
        });
    };

    useEffect(() => {
        const interval = 50; // ms
        const totalTime = 30 * 1000; // 30 detik
        startRef.current = Date.now(); // set start timer

        intervalRef.current = setInterval(() => {
            const elapsed = Date.now() - startRef.current;
            const newProgress = Math.min((elapsed / totalTime) * 100, 100);
            setProgress(newProgress);

            if (elapsed >= totalTime) {
                reloadCaptcha();
                startRef.current = Date.now(); // reset timer
            }
        }, interval);

        return () => clearInterval(intervalRef.current);
    }, []);

    return (
        <>
            <Head title="Login" />
            <div className="row authentication authentication-cover-main mx-0">
                <div className="col-xxl-9 col-xl-9">
                    <div className="row justify-content-center align-items-center h-100">
                        <div className="col-xxl-4 col-xl-5 col-lg-6 col-md-6 col-sm-8 col-12">
                            <div className="card custom-card border-0 shadow-none my-4">
                                <div className="card-body p-5">
                                    <div className="mb-4 text-center">
                                        <img
                                            src={logoTextSrc}
                                            alt="Logo"
                                            className="mx-auto d-block mb-2 desktop-logo"
                                            style={{ height: '40px' }}
                                        />
                                    </div>

                                    <form onSubmit={submit} className="row gy-3">
                                        {/* Username */}
                                        <div className="col-xl-12">
                                            <label htmlFor="name" className="form-label text-default">
                                                Username
                                            </label>
                                            <input
                                                id="name"
                                                name="name"
                                                type="text"
                                                placeholder="Masukkan Username"
                                                value={data.name}
                                                onChange={(e) => setData('name', e.target.value)}
                                                className={`form-control ${errors.name ? 'is-invalid' : ''}`}
                                                autoFocus
                                                required
                                            />
                                            {errors.name && (
                                                <div className="invalid-feedback">{errors.name}</div>
                                            )}
                                        </div>

                                        {/* Password */}
                                        <div className="col-xl-12 mb-2">
                                            <label htmlFor="password" className="form-label text-default d-block">
                                                Password
                                            </label>
                                            <div className="position-relative">
                                                <input
                                                    id="password"
                                                    name="password"
                                                    type={showPassword ? 'text' : 'password'}
                                                    placeholder="Masukkan Password"
                                                    value={data.password}
                                                    onChange={(e) => setData('password', e.target.value)}
                                                    className={`form-control ${errors.password ? 'is-invalid' : ''}`}
                                                    required
                                                />
                                                <button
                                                    type="button"
                                                    className="show-password-button text-muted position-absolute end-0 top-0 h-100 border-0 bg-transparent"
                                                    onClick={() => setShowPassword(!showPassword)}
                                                >
                                                    <i
                                                        className={`ri ${showPassword ? 'ri-eye-off-line' : 'ri-eye-line'} align-middle`}
                                                    ></i>
                                                </button>
                                                {errors.password && (
                                                    <div className="invalid-feedback d-block">{errors.password}</div>
                                                )}
                                            </div>

                                            {/* Remember Me + Forget Password */}
                                            <div className="mt-2 d-flex justify-content-between align-items-center">
                                                <div className="form-check">
                                                    <input
                                                        className="form-check-input"
                                                        type="checkbox"
                                                        checked={data.remember}
                                                        onChange={(e) => setData('remember', e.target.checked)}
                                                        id="rememberMe"
                                                    />
                                                    <label className="form-check-label" htmlFor="rememberMe">
                                                        Ingat Saya
                                                    </label>
                                                </div>
                                                <a
                                                    role='button'
                                                    // href={route('lupa.password.get')}
                                                    className="link-danger fw-medium fs-12"
                                                >
                                                    Lupa Password?
                                                </a>
                                            </div>
                                        </div>

                                        {/* Captcha */}
                                        <div className="col-xl-12 mb-2">
                                            <label className="form-label text-default">Selesaikan Captcha</label>
                                            <div className="input-group align-items-center mt-2">
                                                <img
                                                    src={captchaImage}
                                                    alt="captcha"
                                                    className="rounded border"
                                                    style={{ height: '38px', marginRight: '8px' }}
                                                    onLoad={handleCaptchaLoad}
                                                />
                                                <input
                                                    type="number"
                                                    name="captcha"
                                                    inputMode="numeric"
                                                    value={data.captcha}
                                                    onChange={(e) => setData('captcha', e.target.value)}
                                                    className={`form-control ${errors.captcha ? 'is-invalid' : ''}`}
                                                    placeholder="Tulis Hasil (+)"
                                                    required
                                                />
                                                <button
                                                    type="button"
                                                    className="btn btn-outline-warning"
                                                    onClick={reloadCaptcha}
                                                >
                                                    <i className={`fas fa-sync ${spinning ? 'fa-spin' : ''}`}></i>
                                                </button>
                                                {errors.captcha && (
                                                    <div className="invalid-feedback d-block">{errors.captcha}</div>
                                                )}
                                            </div>
                                        </div>
                                        <div className="progress mt-1" style={{ height: '4px' }}>
                                            <div
                                                className="progress-bar bg-warning"
                                                role="progressbar"
                                                style={{ width: `${progress}%` }}
                                            ></div>
                                        </div>

                                        {/* Submit */}
                                        <div className="col-12 d-grid mt-3">
                                            <button
                                                type="submit"
                                                className="btn btn-primary"
                                                disabled={processing}
                                            >
                                                Sign In
                                            </button>
                                        </div>

                                        {/* OR separator */}
                                        <div className="col-12 text-center my-3 authentication-barrier">
                                            <span className="op-4 fs-13">OR</span>
                                        </div>

                                        {/* Social login buttons */}
                                        <div className="col-12 mb-3" hidden={true}>
                                            <button className="btn btn-white btn-w-lg border d-flex align-items-center justify-content-center flex-fill mb-3">
                                                <span className="avatar avatar-xs">
                                                    <img src="/react/images/media/apps/google.png" alt="" />
                                                </span>
                                                <span className="lh-1 ms-2 fs-13 text-default fw-medium">
                                                    Signup with Google
                                                </span>
                                            </button>
                                            <button className="btn btn-white btn-w-lg border d-flex align-items-center justify-content-center flex-fill">
                                                <span className="avatar avatar-xs flex-shrink-0">
                                                    <img src="/react/images/media/apps/facebook.png" alt="" />
                                                </span>
                                                <span className="lh-1 ms-2 fs-13 text-default fw-medium">
                                                    Signup with Facebook
                                                </span>
                                            </button>
                                        </div>

                                        {/* Register link */}
                                        <div className="col-12 text-center mt-0 fw-medium">
                                            Belum memiliki Akun?{' '}
                                            <a role='button' className="text-primary">
                                                Hubungi SDI
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Cover / Right side */}
                <div className="col-xxl-3 col-xl-3 col-lg-12 d-xl-block d-none px-0">
                    <div className="authentication-cover overflow-hidden">
                        <div className="authentication-cover-logo">
                            <a role='button'>
                                <img src={logoSrc} alt="logo" className="desktop-dark" />
                            </a>
                        </div>
                        <div className="authentication-cover-background">
                            <img src="/react/images/media/backgrounds/9.png" alt="" />
                        </div>
                        <div className="authentication-cover-content">
                            <div className="p-5">
                                <h3 className="fw-semibold lh-base">Hi, Selamat Datang 👋</h3>
                                <p className="mb-0 text-muted fw-medium">
                                    Silakan masuk menggunakan Akun Simrsmu Anda untuk melanjutkan Peluncuran Dashboard.
                                </p>
                            </div>
                            <div>
                                <img src="/react/images/media/media-72.png" alt="" className="img-fluid" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
