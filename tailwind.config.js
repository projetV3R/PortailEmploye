/** @type {import('tailwindcss').Config} */
import forms from "@tailwindcss/forms";
export default {
    darkMode: "class",
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "node_modules/preline/dist/*.js",
    ],
    theme: {
        extend: {
            colors: {
                daltonienYellow: '#FACC15',
                daltonienBleu: "#849ED2",
                blueV3R: "#0B2341",
                primary: {
                    100: "#EFF8FC",
                    200: "#DEF1F8",
                    300: "#BCE3F0",
                    400: "#78C6E0",
                },
                secondary: {
                    100: "#E0EEFA",
                    200: "#C0DDF5",
                    300: "#80BBEA",
                    400: "#0076D5",
                },
                tertiary: {
                    100: "#E1E4E8",
                    200: "#C2C8D0",
                    300: "#8591A0",
                    400: "#0B2341",
                },
            },
            fontFamily: {
                Alumni: ["Alumni Sans", "sans-serif"],
            },
        },
    },
    plugins: [
        forms, // Ajout de @tailwindcss/forms
        require("tailwindcss/plugin")(function ({ addVariant, e }) {
            addVariant("daltonien", ({ modifySelectors, separator }) => {
                modifySelectors(({ className }) => `html.daltonien .${e(`daltonien${separator}${className}`)}`);
            });
        }),
    ],
};
