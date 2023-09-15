"use-strict";

//select 1 value lalu tampilkan element yang sesuai (non-ajax) contoh pilih metode pembayaran
!function () {
    const c = document.querySelector('.k-select-hide');
    let s, t = document.querySelector('.k-select-hide-main'), p = t ? t.querySelector('select') : '';
    s = c ? c.querySelectorAll('.k-select-hide-child') : document.querySelectorAll('.k-select-hide-child');
    s && s.forEach((e) => {
        he = e.hasAttribute('hidden');
        if (!he) {
            e.setAttribute('hidden', 'hidden');
        }
    });
    p && p.addEventListener('change', () => {
        i = p.selectedIndex - 1;

        s.forEach((e) => {
            if (e !== s[i]) {
                e.setAttribute('hidden', 'hidden');
            } else {
                e.removeAttribute('hidden');
            }
        });
    });
}()
// pilih tipe transaksi dan fungsi lain yang bersangkutan
function radioShowHide(checkTipeTransaksi, showDataTrx, trxPny, trxBaru, validateForms) {
    const c = document.querySelector('.k-radio-show-hide');
    const r = document.querySelectorAll('.k-radio-hidden');
    const i = c.querySelectorAll('input');

    i && i.forEach(e => {
        if (checkTipeTransaksi) {
            if (typeof checkTipeTransaksi === 'function') {
                checkTipeTransaksi();
            }
        }
        e.addEventListener('change', (el) => {
            let ch = el.currentTarget;
            if (showDataTrx) {
                if (typeof showDataTrx === "function") {
                    showDataTrx();
                }
            }
            if (ch.checked) {
                if (ch.value == "penyesuaian" || ch.getAttribute("id") == "trx-penyesuaian") {
                    // let d = el.target.hasAttribute('data-sh') ? el.target.getAttribute('data-sh') : null;
                    // if (d) {
                    //     let h = document.querySelector('#' + d);
                    //     h.removeAttribute('hidden');

                    // } else {
                    //     r.forEach((t) => {
                    //         t.setAttribute('hidden', 'hidden')
                    //     })
                    // }
                    r.forEach(el => {
                        el.removeAttribute("hidden");
                    });
                    if (trxPny) {
                        if (typeof trxPny === 'function') {
                            trxPny();
                        }
                    }
                } else {
                    r.forEach((t) => {
                        t.setAttribute('hidden', 'hidden')
                    })
                    if (trxBaru) {
                        if (typeof trxBaru === 'function') {
                            trxBaru();
                        }
                    }
                }

                if (validateForms) {
                    if (typeof validateForms === "function") {
                        validateForms();
                    }
                }
            }
        })
    })
}



