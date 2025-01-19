import defaultTheme from "tailwindcss/defaultTheme";
import plugin from 'tailwindcss/plugin';

/** @type {import('tailwindcss').Config} */

export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            backgroundImage: {
                "gradient-black":
                    "linear-gradient(180deg, #444242 10.5%, rgba(24, 23, 23, 0.95))",
            },
            colors: {
                amber: {
                    100: "#fef3c7",
                    200: "#fde68a",
                    300: "#fcd34d",
                    400: "#fbbf24",
                    500: "#f59e0b",
                    600: "#d97706",
                    700: "#b45309",
                    800: "#92400e",
                    900: "#78350f",
                },
            },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                inter: ["Inter", "sans-serif"],
                nunito: ["Nunito", "sans-serif"],
            },
            keyframes: {
                grow: {
                    "0%": { width: "0%" },
                    "50%": { width: "100%" },
                    "100%": { width: "0%" },
                },
                fadeInUp: {
                    "0%": {
                        opacity: "0",
                        transform: "translateY(10px)",
                    },
                    "100%": {
                        opacity: "1",
                        transform: "translateY(0)",
                    },
                },
                appear: {
                    "0%": {
                        display: "block",
                        opacity: "0",
                        transform: "scale(0)",
                    },
                    "100%": {
                        display: "block",
                        opacity: "1",
                        transform: "scale(1)",
                    },
                },
            },
            animation: {
                grow: "grow 2s ease-out infinite",
                fadeInUp: "fadeInUp 1.5s ease-out forwards",
                appear: "appear 0.3s ease-out forwards",
            },
            fontSize: {
                'normal': '12px',
                'medium': '16px',
                'large': '32px',
            },
            lineHeight: {
                'normal': '130%',
                'medium': '125%',
                'large': '130%',
            },
        },
    },
    plugins: [
        plugin(function({ addUtilities, addComponents }) {
            addUtilities({
                '.text-normal': {
                    'font-family': 'Inter',
                    'font-size': '12px',
                    'font-weight': '400',
                    'line-height': '130%',
                    'font-style': 'normal',
                    'color': '#FFF',
                },
                '.text-medium': {
                    'font-family': 'Inter',
                    'font-size': '14px',
                    'font-style': 'normal',
                    'font-weight': '500',
                    'line-height': '20px',
                    'color': '#FFF',
                },
                '.text-large': {
                    'font-family': 'Nunito',
                    'font-size': '32px',
                    'font-weight': '900',
                    'line-height': '130%',
                    'font-style': 'normal',
                    'color': '#FFF',
                }
            });
            addComponents({
                '.scrollbar-thin': {
                    'overflow-y': 'auto',
                    '&::-webkit-scrollbar': {
                        width: '3px'
                    },
                    '&::-webkit-scrollbar-track': {
                        backgroundColor: '#e5e7eb'
                    },
                    '&::-webkit-scrollbar-thumb': {
                        backgroundColor: 'rgba(21, 94, 117, 0.2)',
                        borderRadius: '10px'
                    },
                    '&::-webkit-scrollbar-thumb:hover': {
                        backgroundColor: 'rgba(21, 94, 117, 0.5)'
                    }
                },
            });
        }),
    ],
};