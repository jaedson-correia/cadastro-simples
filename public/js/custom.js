window.onload = () => {
    const nome = document.querySelector('#nome');
    const tipoPessoa = document.querySelector('#tipo-pessoa');
    const inscricao = document.querySelector('#inscricao');
    const email = document.querySelector('#email');
    const mensagens = document.querySelector('#mensagens');

    const label = document.querySelector('#label-inscricao');
    const form = document.querySelector('#cadastro');

    let mascaras = {
        cpf: '999.999.999-99',
        cnpj: '99.999.999/9999-99'
    };

    VMasker(inscricao).maskPattern(mascaras.cpf);

    tipoPessoa.addEventListener('change', event => {
        label.innerHTML = (tipoPessoa.value == 1 ? 'CPF' : 'CNPJ');
        VMasker(inscricao).maskPattern((tipoPessoa.value == 1 ? mascaras.cpf : mascaras.cnpj));
    });

    form.addEventListener('submit', event => {
        event.preventDefault();
        axios.post('/api/cadastrar', {
            nome: nome.value,
            tipoPessoa: tipoPessoa.value,
            inscricao: inscricao.value,
            email: email.value
        }).then(response => {
            mensagens.innerHTML = `<span class="text-success">${response.data.inscricao} cadastrado com succeso</span>`;
            nome.value = '';
            inscricao.value = '';
            email.value = '';

        }).catch(error => {
            let html = '';
            let erros = error.response.data.errors;
            if (erros) {
                for (const key in erros) {
                    html += `<span class="text-danger">${erros[key]}</span>`
                }
                mensagens.innerHTML = html;
            }
        })
    });
}


