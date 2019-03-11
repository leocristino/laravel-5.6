window.util = new Vue({
    methods: {
        getUrlSegment(numberSegment){
            let path     = window.location.pathname;
            let segments = path.split("/");
            return segments[numberSegment];
        },

        getUrlParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        },

        findInArrayObject(prop, value, array){
            for (var i=0; i < array.length; i++) {
                if (array[i][prop] === value) {
                    return array[i];
                }
            }
        },

        removeFormatting: function(str){
            //remove tudo o que não é numero
            str = str.replace(/[^\d]/g, "");
            return str;
        },

        goBack: function(){
            window.location.href = window.previousUrl;
        },

        /*FUNÇÃO VALIDA CPF
            EXEMPLO DE CAHAMADA|UTILIZAÇÃO: if(!valida_cpf(document.getElementById("CPFCNPJ").value)){}*/
        isCPF: function(cpf){
            var newcpf = '';
            for(i=0; i<=cpf.length; i++)
                if(!isNaN(cpf.substr(i, 1)))
                    newcpf += cpf.substr(i, 1);
            cpf = newcpf;

            var numeros, digitos, soma, i, resultado, digitos_iguais;
            digitos_iguais = 1;
            if (cpf.length < 11)
                return false;
            for (i = 0; i < cpf.length - 1; i++)
                if (cpf.charAt(i) != cpf.charAt(i + 1))
                {
                    digitos_iguais = 0;
                    break;
                }
            if (!digitos_iguais)
            {
                numeros = cpf.substring(0,9);
                digitos = cpf.substring(9);
                soma = 0;
                for (i = 10; i > 1; i--)
                    soma += numeros.charAt(10 - i) * i;
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(0))
                    return false;
                numeros = cpf.substring(0,10);
                soma = 0;
                for (i = 11; i > 1; i--)
                    soma += numeros.charAt(11 - i) * i;
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(1))
                    return false;
                return true;
            }
            else
                return false;
        },

        /*
        =============================================================================================
        FUNÇÃO VALIDA CNPJ
        EXEMPLO DE CAHAMADA|UTILIZAÇÃO: if(!valida_cnpj(document.getElementById("CPFCNPJ").value)){}*/
        isCNPJ: function(cnpj){
            var newcnpj = '';
            for(i=0; i<=cnpj.length; i++)
                if(!isNaN(cnpj.substr(i, 1)))
                    newcnpj += cnpj.substr(i, 1);
            cnpj = newcnpj;

            var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
            digitos_iguais = 1;
            if (cnpj.length < 14 && cnpj.length < 15)
                return false;
            for (i = 0; i < cnpj.length - 1; i++)
                if (cnpj.charAt(i) != cnpj.charAt(i + 1))
                {
                    digitos_iguais = 0;
                    break;
                }
            if (!digitos_iguais)
            {
                tamanho = cnpj.length - 2
                numeros = cnpj.substring(0,tamanho);
                digitos = cnpj.substring(tamanho);
                soma = 0;
                pos = tamanho - 7;
                for (i = tamanho; i >= 1; i--)
                {
                    soma += numeros.charAt(tamanho - i) * pos--;
                    if (pos < 2)
                        pos = 9;
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(0))
                    return false;
                tamanho = tamanho + 1;
                numeros = cnpj.substring(0,tamanho);
                soma = 0;
                pos = tamanho - 7;
                for (i = tamanho; i >= 1; i--)
                {
                    soma += numeros.charAt(tamanho - i) * pos--;
                    if (pos < 2)
                        pos = 9;
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(1))
                    return false;
                return true;
            }
            else
                return false;
        },
    }
});