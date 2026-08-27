module.exports = {
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        brand: {
           50: '#FEF2F2',  100: '#FEE2E2',  500: '#EF4A40',
          600: '#D42A22',  700: '#A81E18',  800: '#7F1611',
          DEFAULT: '#D42A22',
          dark: {
            tint: '#2A0C0A',  ring: '#45120F',  solid: '#D8281F',
            accent: '#F0433A', hover: '#EF3A30', 'on-tint': '#FF8078',
          },
        },
        neutral: {
           50: '#FAFAFA',  100: '#F4F4F5',  200: '#E4E4E7',
          300: '#D4D4D8',  400: '#A1A1AA',  500: '#71717A',
          700: '#3F3F46',  800: '#27272A',  850: '#1F1F23',
          900: '#18181B',  950: '#0A0A0A',
        },
        success: {
          DEFAULT: '#16A34A', fg: '#15803D', bg: '#F0FDF4', border: '#BBF7D0',
          'dark-dot': '#22C55E', 'dark-fg': '#4ADE80', 'dark-bg': '#0B2A16', 'dark-border': '#14532D',
        },
        warning: {
          DEFAULT: '#D97706', fg: '#B45309', bg: '#FFFBEB', border: '#FDE68A',
          'dark-dot': '#F59E0B', 'dark-fg': '#FBBF24', 'dark-bg': '#2B1C05', 'dark-border': '#78350F',
        },
        danger: {
          DEFAULT: '#DC2626', fg: '#B91C1C', bg: '#FEF2F2', border: '#FECACA',
          'dark-dot': '#EF4444', 'dark-fg': '#F87171', 'dark-bg': '#2A0C0A', 'dark-border': '#7F1D1D',
        },
      },
      fontFamily: {
        display: ['Archivo', 'system-ui', 'sans-serif'],
        sans:    ['Inter', 'system-ui', 'sans-serif'],
        mono:    ['JetBrains Mono', 'ui-monospace', 'monospace'],
      },
      borderRadius: { DEFAULT: '6px', md: '6px', lg: '8px' },
      boxShadow: {
        sm: '0 1px 2px rgba(24,24,27,0.05)',
        md: '0 4px 12px rgba(24,24,27,0.08), 0 1px 2px rgba(24,24,27,0.04)',
        none: 'none',
      },
    },
  },
}