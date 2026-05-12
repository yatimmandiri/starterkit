export const formatNumberWhatsapp = (value: string) => {
    if (!value) return '';

    // hapus semua karakter selain angka
    let number = value.replace(/\D/g, '');

    // jika diawali 0 → ganti dengan 62
    if (number.startsWith('0')) {
        number = '62' + number.slice(1);
    }

    // jika diawali 8 (user input tanpa 0) → tambahkan 62
    if (number.startsWith('8')) {
        number = '62' + number;
    }

    // jika sudah 62 → biarkan
    if (number.startsWith('62')) {
        return number;
    }

    return number;
};

export const formatRupiah = ({ value, prefix = 'Rp' }: FormatRupiahProps) => {
    const formatted = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(Number(value));

    return `${prefix} ${formatted.replace('Rp', '').trim()}`;
};

export const formatNumber = (value: string) => {
    const cleaned = value.replace(/\D/g, ''); // hapus semua non-digit

    return cleaned.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // tambahkan titik setiap 3 digit
};

export const onlyNumber = (value: string) => {
    return value.replace(/[^0-9]/g, '');
};

interface FormatRupiahProps {
    value: number | string;
    prefix?: string; // default: "Rp"
}
