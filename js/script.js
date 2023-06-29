
const nameAndLastname = document.getElementById('name');
const alias = document.getElementById('alias');
const rut = document.getElementById('rut');
const email = document.getElementById('email');
const region = document.getElementById('region');
const commune = document.getElementById('commune');
const candidate = document.getElementById('candidate');
const knowus = document.getElementsByName('knowus');

const voteForm = document.getElementById('voteForm')
const showToastAlert = (title, icon) => {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        onOpen: (toast) => {
            const icon = toast.querySelector('.swal2-icon');

            icon.style.fontSize = '14px';
            icon.style.transform = 'scale(0.8)';
        }
    })

    Toast.fire({ icon, title })
}

voteForm.addEventListener('submit', event => {
    event.preventDefault()
    let errors = []

    if (nameAndLastname.value.trim() === '') errors.push('El nombre es obligatorio')
    if (!aliasIsValid(alias.value)) errors.push('El alias debe tener un minimo de 5 caracteres incluyendo letras y numeros')
    if (!rutIsValid(rut.value)) errors.push('El rut ingresado no es valido')
    if (!emailIsValid(email.value)) errors.push('El correo ingresado no es valido')
    if (region.value === "#") errors.push('La region es obligatoria')
    if (commune.value === "#") errors.push('La comuna es obligatoria')
    if (candidate.value === "#") errors.push('El candidato es obligatorio')
    if (validateCheckboxes()) errors.push('Se deben seleccionar al menos dos checkboxs')

    if (errors.length > 0) {
        errors.forEach((error) => showToastAlert(error, 'error'))
        return
    }

    const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    const listCheckValues = [];
    checkboxes.forEach((checkbox) => listCheckValues.push(checkbox.value));

    const formData = new FormData();

    formData.append('name', nameAndLastname.value);
    formData.append('alias', alias.value);
    formData.append('rut', rut.value);
    formData.append('email', email.value);
    formData.append('tbl_region', region.value);
    formData.append('tbl_commune', commune.value);
    formData.append('id_candidate', candidate.value);
    formData.append('knowus', listCheckValues);


    fetch('/vote', {
        method: 'POST',
        body: formData
    })
        .then(resp => {
            if (resp.status === 401) {
                resp.json().then((error) => showToastAlert(error, 'error'))
                throw new Error(resp)
            }
            return resp.json()
        })
        .then(data => {
            showToastAlert(data, 'success')
        })
        .catch(error => {
            console.log(error)
        })

})

const aliasIsValid = (inputString) => {
    const regex = /^(?=.*[a-zA-Z])(?=.*\d).{6,}$/;
    return regex.test(inputString);
}

const rutIsValid = (rutToVerify) => {
    // Eliminar puntos y guión del rut
    rutToVerify = rutToVerify.replace(/\./g, '').replace(/-/g, '');

    // Extraer dígito verificador y cuerpo del rut
    const rutDigits = rutToVerify.slice(0, -1);
    const verificador = rutToVerify.slice(-1).toUpperCase();

    // Calcular dígito verificador esperado
    let factor = 2;
    let sum = 0;

    for (let i = rutDigits.length - 1; i >= 0; i--) {
        sum += parseInt(rutDigits[i]) * factor;
        factor = factor === 7 ? 2 : factor + 1;
    }

    const expectedVerificador = 11 - (sum % 11);
    const calculatedVerificador = expectedVerificador === 11 ? '0' : expectedVerificador === 10 ? 'K' : String(expectedVerificador);

    // Comparar dígito verificador esperado con el ingresado

    return verificador === calculatedVerificador;
}

const emailIsValid = (email) => {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

const validateCheckboxes = () => {
    checkboxSelected = 0;
    for (let i = 0; i < knowus.length; i++) {
        if (knowus[i].checked) checkboxSelected += 1;
    }
    return checkboxSelected < 2
}

region.addEventListener('change', async (e) => {

    if (e.target.value === "#") {
        commune.innerHTML = '<option value="#">Seleccione</option>';
        commune.disabled = true
        return
    }
    commune.disabled = false
    try {
        const resp = await fetch(`/api/communes/region?idRegion=${e.target.value}`);
        const data = await resp.json();
        communes = data.flat();
        commune.innerHTML = '<option value="#">Seleccione</option>';
        communes.forEach(({ id, nombre }) => {
            const option = document.createElement('option');
            option.value = id;
            option.innerHTML = nombre;
            commune.appendChild(option)
        });

    } catch (error) {
        console.log(error);
    }
})

rut.addEventListener('input', function () {
    console.log(1)
    let rutMask = rut.value.replace(/[^\dkK]+/g, '');

    if (rutMask.length > 1) {
        rutMask = rutMask.substring(0, rutMask.length - 1) + '-' + rutMask.charAt(rutMask.length - 1);
    }

    if (rut.value.length > 10) {
        rut.value = rut.value.slice(0, 10)
        return
    }
    rut.value = rutMask;
});