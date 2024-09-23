/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        Alumni: ["Alumni Sans", "sans-serif"],
    },
    colors: {
      'blueV3R': '#0B2341',
    },
    },
  },
  plugins: [],
}