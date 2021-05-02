document.addEventListener('DOMContentLoaded', () => {
    
    const switchers = document.querySelectorAll('.switcher');

    console.log(switchers);

    switchers.forEach(item => {
        item.addEventListener('click', function() {

            console.log("test");

            switchers.forEach(item => item.parentElement.classList.remove("is-active"));
            this.parentElement.classList.add("is-active");
        })
    })
});