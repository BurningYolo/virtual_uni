
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');
const header = document.querySelector('.header');
const toggleButton = document.getElementById('toggleSidebar');

toggleButton.addEventListener('click', () => {
    sidebar.classList.toggle('hidden');
    mainContent.classList.toggle('hidden');
    header.classList.toggle('collapsed');
});
