import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: [
                    "DM Sans",
                    "Inter",
                    "system-ui",
                    ...defaultTheme.fontFamily.sans,
                ],
                serif: ["Merriweather", "Playfair Display", "Georgia", "serif"],
                display: ["Libre Baskerville", "Playfair Display", "serif"],
            },
            fontSize: {
                xs: ["0.75rem", { lineHeight: "1rem" }],
                sm: ["0.875rem", { lineHeight: "1.25rem" }],
                base: ["1rem", { lineHeight: "1.5rem" }],
                lg: ["1.125rem", { lineHeight: "1.75rem" }],
                xl: ["1.25rem", { lineHeight: "1.75rem" }],
                "2xl": ["1.5rem", { lineHeight: "2rem" }],
                "3xl": ["1.875rem", { lineHeight: "2.25rem" }],
                "4xl": ["2.25rem", { lineHeight: "2.5rem" }],
                "5xl": ["3rem", { lineHeight: "1.16" }],
                "6xl": ["3.75rem", { lineHeight: "1.12" }],
            },
            colors: {
                // Brand colors (Red theme)
                brand: {
                    50: "#FEF2F2",
                    100: "#FEE2E2",
                    200: "#FECACA",
                    300: "#FCA5A5",
                    400: "#F87171",
                    500: "#EF4444",
                    600: "#DC2626",
                    700: "#B91C1C",
                    800: "#991B1B",
                    900: "#7F1D1D",
                },
                // Editorial colors
                paper: "#FAFAFA",
                dark: "#18181B",
                // Keep primary as alias to brand for backward compatibility
                primary: {
                    50: "#FEF2F2",
                    100: "#FEE2E2",
                    200: "#FECACA",
                    300: "#FCA5A5",
                    400: "#F87171",
                    500: "#EF4444",
                    600: "#DC2626",
                    700: "#B91C1C",
                    800: "#991B1B",
                    900: "#7F1D1D",
                },
            },
            spacing: {
                18: "4.5rem",
                88: "22rem",
                100: "25rem",
                120: "30rem",
            },
            maxWidth: {
                "8xl": "88rem",
                "9xl": "96rem",
            },
            boxShadow: {
                soft: "0 4px 20px -2px rgba(0, 0, 0, 0.05)",
                hover: "0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1)",
                card: "0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px -1px rgba(0, 0, 0, 0.04)",
            },
            borderRadius: {
                xl: "1rem",
                "2xl": "1.5rem",
                "3xl": "2rem",
            },
            keyframes: {
                fadeInUp: {
                    "0%": { opacity: "0", transform: "translateY(12px)" },
                    "100%": { opacity: "1", transform: "translateY(0)" },
                },
                wiggle: {
                    "0%, 100%": { transform: "rotate(-1deg)" },
                    "50%": { transform: "rotate(1deg)" },
                },
            },
            animation: {
                "fade-in-up": "fadeInUp 0.5s ease-out both",
                wiggle: "wiggle 1s ease-in-out infinite",
            },
            typography: (theme) => ({
                DEFAULT: {
                    css: {
                        maxWidth: "none",
                        color: theme("colors.gray.700"),
                        a: {
                            color: theme("colors.brand.600"),
                            "&:hover": {
                                color: theme("colors.brand.700"),
                            },
                        },
                        h1: {
                            fontFamily: theme("fontFamily.display").join(", "),
                            fontWeight: "700",
                        },
                        h2: {
                            fontFamily: theme("fontFamily.serif").join(", "),
                            fontWeight: "700",
                        },
                        h3: {
                            fontFamily: theme("fontFamily.serif").join(", "),
                            fontWeight: "600",
                        },
                    },
                },
                red: {
                    css: {
                        "--tw-prose-links": theme("colors.brand.600"),
                        "--tw-prose-counters": theme("colors.brand.600"),
                        "--tw-prose-bullets": theme("colors.brand.400"),
                    },
                },
            }),
        },
    },

    plugins: [forms, typography],
};
