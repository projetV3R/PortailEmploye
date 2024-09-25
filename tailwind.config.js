/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    'node_modules/preline/dist/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        Alumni: ["Alumni Sans", "sans-serif"],
    },
    },
  },
  plugins: [
    require('preline/plugin'),
  ],
}