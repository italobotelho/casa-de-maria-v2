//Função para formatar telefones

const phoneInput = document.getElementById('telefone_clin');

phoneInput.addEventListener('input', (e) => {
    const phoneNumber = e.target.value.replace(/\D+/g, '');
    const formattedPhoneNumber = formatPhone(phoneNumber);
    e.target.value = formattedPhoneNumber;
});

function formatPhone(str) {
    return str.replace(/(?:([1-9]{2})|([0-9]{3})?)(\d{4,5})(\d{4})/,
        (fullMatch, ddd, dddWithZero, prefixTel, suffixTel) => {
            if (ddd || dddWithZero) return `(${ ddd || dddWithZero }) ${ prefixTel }-${ suffixTel}`;
            if (prefixTel && suffixTel) return `${ prefixTel }-${ suffixTel }`;
            return str;
        }
    );
}