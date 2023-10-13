/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './vendor/wire-elements/modal/resources/views/*.blade.php',
    './storage/framework/views/*.php',
  ],
  theme: {
    extend: {
      screens: {
        sm: '576px',
        md: '768px',
        lg: '1024px',
        xl: '1278px',
        xxl: '1440px',
      },
    },
  },
  daisyui: {
    themes: [{
      mytheme: {
        "primary": "#15326c",
        "secondary": "#96bddb",
        "accent": "#578ab1",
        "neutral": "#3d4451",
        "base-100": "#fcfdff",
      },
    }],
  },
  plugins: [
    require('daisyui','flowbite/plugin'),
  ],
}
