// Script for dismissible alerts, etc.
document.addEventListener('DOMContentLoaded', () => {
  const alerts = document.querySelectorAll('.alert-dismissible .btn-close');
  alerts.forEach(btn => {
    btn.addEventListener('click', () => {
      btn.parentElement.style.display = 'none';
    });
  });
});
