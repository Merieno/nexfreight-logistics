<script>

if(localStorage.theme === 'dark') {
    document.documentElement.classList.add('dark');
}

document.getElementById('themeToggle')
.addEventListener('click', () => {

    document.documentElement.classList.toggle('dark');

    if(document.documentElement.classList.contains('dark')) {

        localStorage.theme = 'dark';

    } else {

        localStorage.theme = 'light';

    }

});

</script>

</body>
</html>