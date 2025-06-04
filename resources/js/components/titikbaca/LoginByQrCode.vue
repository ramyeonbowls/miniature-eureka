<template>
  <div>
    <p>Logging in...</p>
  </div>
</template>

<script>
export default {
  async mounted() {
    const idt = this.$route.params.idt;

    try {
        const response = await axios.post('/login-by-qr', { id: idt });
        if (response.data.uuid) {
            sessionStorage.setItem('isLoggedInQR', 'true');
            sessionStorage.setItem('uuid', response.data.uuid);
            sessionStorage.setItem('place', response.data.place);

            window.location.href = '/';
        } else {
            this.$router.replace({ name: 'NotFound' });
        }
    } catch (error) {
        console.error('Login by QR failed:', error);
        this.$router.replace({ name: 'NotFound' });
    }
  }
}
</script>
