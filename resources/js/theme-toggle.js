document.addEventListener('alpine:init', () => {
  Alpine.data('themeToggle', () => ({
    darkMode: localStorage.getItem('darkMode') === 'true',
    init() {
      if (localStorage.getItem('darkMode') === null) {
        this.darkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
      }
      if (this.darkMode) {
        document.documentElement.classList.add('dark');
      }
    },
    toggleDark() {
      this.darkMode = !this.darkMode;
      localStorage.setItem('darkMode', this.darkMode);
      document.documentElement.classList.toggle('dark');
    }
  }));
});
