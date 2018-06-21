function submitForm(action) {
    let form = document.getElementById('baseform');
    form.action = action;
    form.submit();
}