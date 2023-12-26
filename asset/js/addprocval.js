function formatNominal(input) {
    // Hapus karakter selain digit (0-9)
    let cleanedValue = input.value.replace(/\D/g, '');

    // Format nominal dengan menambahkan titik setiap 3 digit dari belakang
    cleanedValue = cleanedValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    // Set nilai input dengan format nominal
    input.value = cleanedValue;
  }
