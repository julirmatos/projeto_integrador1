document.getElementById('contactForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);

  try {
    const response = await fetch(form.action, {
      method: 'POST',
      body: formData
    });

    const result = await response.text();
    document.getElementById('formMessage').innerText = result;
    form.reset();
  } catch (error) {
    document.getElementById('formMessage').innerText = "Erro ao enviar. Tente novamente.";
    console.error(error);
  }
});
