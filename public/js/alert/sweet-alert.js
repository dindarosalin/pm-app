const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    animation: false,
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)   
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.addEventListener('swal:modal', event => {
    const data = event.detail[0];
    Toast.fire({
        title: data.message,
        text: data.text,
        icon: data.type,
    });
});

window.addEventListener('swal:confirm', event => {
    const data = event.detail[0];
    // console.log(data.id);
    Swal.fire({
        title: data.message,
        text: data.text,
        icon: data.type,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch(data.dispatch, {
                id: data.id
            });
        }
    });
});

