import { useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import InputError from '@/Components/InputError';

export default function Login() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        password: '',
        captcha: '',
        remember: false,
    });

    const [showPassword, setShowPassword] = useState(false);
    const [captchaImage, setCaptchaImage] = useState('/captcha/math');

    const reloadCaptcha = () => {
        setCaptchaImage(`/captcha/math?${Date.now()}`);
    };

    const submit = (e) => {
        e.preventDefault();
        post(route('login'), {
            onFinish: () => reset('password', 'captcha'),
        });
    };

    return (
        <>
            <Head title="Login" />
            <div className="auth-main">
                <div className="auth-wrapper v1">
                    <div className="auth-form">
                        <div className="card shadow-lg border-0 rounded-4 p-4">
                            <div className="text-center mb-3">
                                <img
                                    src="/images/logo/logo_simrsmu_new_kop_31.png"
                                    alt="Logo"
                                    className="mx-auto d-block"
                                    style={{ height: '55px' }}
                                />
                                <h5 className="fw-semibold mt-3 text-primary">
                                    Selamat Datang 👋
                                </h5>
                                <p className="text-muted small mb-0">
                                    Silakan masuk terlebih dahulu
                                </p>
                            </div>

                            <form onSubmit={submit} className="mt-3">
                                {/* Username */}
                                <div className="mb-3">
                                    <InputLabel htmlFor="name" value="Username" />
                                    <TextInput
                                        id="name"
                                        name="name"
                                        type="text"
                                        value={data.name}
                                        className="form-control mt-1"
                                        onChange={(e) => setData('name', e.target.value)}
                                        required
                                        autoFocus
                                    />
                                    <InputError message={errors.name} className="mt-1" />
                                </div>

                                {/* Password */}
                                <div className="mb-3">
                                    <InputLabel htmlFor="password" value="Password" />
                                    <div className="input-group">
                                        <TextInput
                                            id="password"
                                            name="password"
                                            type={showPassword ? 'text' : 'password'}
                                            value={data.password}
                                            className="form-control"
                                            onChange={(e) =>
                                                setData('password', e.target.value)
                                            }
                                            required
                                        />
                                        <button
                                            type="button"
                                            onClick={() => setShowPassword(!showPassword)}
                                            className="btn btn-outline-primary"
                                        >
                                            <i
                                                className={`fas ${
                                                    showPassword ? 'fa-eye-slash' : 'fa-eye'
                                                }`}
                                            ></i>
                                        </button>
                                    </div>
                                    <InputError message={errors.password} className="mt-1" />
                                </div>

                                {/* Captcha */}
                                <div className="mb-3">
                                    <InputLabel value="Selesaikan Captcha" />

                                    <div className="input-group align-items-center mt-2">
                                        {/* Gambar captcha di kiri */}
                                        <img
                                            src={captchaImage}
                                            alt="captcha"
                                            className="rounded border"
                                            style={{ height: '38px', marginRight: '8px' }}
                                        />

                                        {/* Input + tombol reload */}
                                        <input
                                            type="text"
                                            name="captcha"
                                            inputMode="numeric"
                                            value={data.captcha}
                                            onChange={(e) => setData('captcha', e.target.value)}
                                            className="form-control"
                                            placeholder="Tulis hasil penjumlahan"
                                            required
                                        />
                                        <button
                                            type="button"
                                            className="btn btn-outline-primary"
                                            onClick={reloadCaptcha}
                                        >
                                            Reload
                                        </button>
                                    </div>

                                    <InputError message={errors.captcha} className="mt-1" />
                                </div>

                                {/* Remember Me */}
                                <div className="d-flex justify-content-between align-items-center mb-3">
                                    <label className="form-check-label small">
                                        <input
                                            type="checkbox"
                                            name="remember"
                                            checked={data.remember}
                                            onChange={(e) =>
                                                setData('remember', e.target.checked)
                                            }
                                            className="form-check-input me-1"
                                        />
                                        Ingat Saya
                                    </label>
                                    <a
                                        href={route('password.request')}
                                        className="text-decoration-none text-primary small"
                                    >
                                        Lupa Password?
                                    </a>
                                </div>

                                <button
                                    className="btn btn-primary w-100"
                                    type="submit"
                                    disabled={processing}
                                >
                                    Masuk
                                </button>
                            </form>

                            <div className="text-center mt-3 small">
                                <span>Belum punya akun? </span>
                                <button
                                    onClick={() =>
                                        alert(
                                            'Hubungi IT dengan menelepon 102 (No. Telp Internal RS)'
                                        )
                                    }
                                    className="btn btn-link p-0 text-decoration-none text-primary"
                                >
                                    Hubungi IT
                                </button>
                            </div>

                            <div className="text-center text-muted mt-4 small">
                                © {new Date().getFullYear()} Made with ❤️ by{' '}
                                <a
                                    href="https://instagram.com/hiyussuf"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-pink-500 text-decoration-none"
                                >
                                    hiyussuf
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
