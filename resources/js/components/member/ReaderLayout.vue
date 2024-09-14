<template>
    <div class="pdf-layout">
      <router-view></router-view> <!-- Where the PdfReader component will be rendered -->
    </div>
  </template>
  
  <script>
  export default {
    name: 'PdfLayout'
  }
  </script>
  
  <style scoped>
  .pdf-layout {
    width: 100vw;
    height: 100vh;
  }
  </style>
  