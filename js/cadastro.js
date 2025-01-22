
// Função para validar a senha
function validatePassword() {
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm_password").value;
    let passwordMessage = document.getElementById("password-error-message");
    let confirmMessage = document.getElementById("error-message");

// Expressão regular para validar a senha (mínimo 8 caracteres, incluindo números, letras maiúsculas, minúsculas e caracteres especiais)
const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&,.])[A-Za-z\d@$!%*?&,.]{8,}$/;

// Verifica se a senha atende aos requisitos
if (!passwordRegex.test(password)) {
    passwordMessage.innerText = "A senha deve ter pelo menos 8 caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.";
    document.getElementById("password").classList.add("is-invalid");
    return false;
} else {
    passwordMessage.innerText = "";
    document.getElementById("password").classList.remove("is-invalid");
    document.getElementById("password").classList.add("is-valid");
}

// Verifica se as senhas conferem
if (password !== confirmPassword) {
    confirmMessage.innerText = "Senhas não conferem!";
    document.getElementById("confirm_password").classList.add("is-invalid");
    return false;
} else {
    confirmMessage.innerText = "";
    document.getElementById("confirm_password").classList.remove("is-invalid");
    document.getElementById("confirm_password").classList.add("is-valid");
    return true;
}
}