document.addEventListener("DOMContentLoaded",function(){function l(){var e=0;document.querySelectorAll(".table tbody tr").forEach(function(t){t=parseFloat(t.querySelector(".table-item-subprice").textContent.replace("$",""));e+=t}),document.querySelector(".totalamount").textContent="$"+e.toFixed(2)}function u(){var o=0,t=(document.querySelectorAll(".table tbody tr").forEach(function(t){var e=parseFloat(t.querySelector(".table-item-price").textContent.replace("$","")),n=parseInt(t.querySelector(".quantity").textContent),e=e*n;t.querySelector(".table-item-subprice").textContent="$"+e.toFixed(2),o+=e,0}),document.querySelector(".subtotal_price").textContent="$"+o.toFixed(2),document.querySelector(".totalamount").textContent="$"+o.toFixed(2),parseFloat(document.querySelector(".discount").value));isNaN(t)||(t=o-t,document.querySelector(".totalamount").textContent="$"+t.toFixed(2))}document.querySelectorAll(".card.widget-icon-box").forEach(function(t){t.addEventListener("click",function(){var t,e=this.querySelector(".text-muted").children[0].textContent.trim(),n=this.querySelector(".text-muted .badge").textContent.trim(),o=this.querySelector("img").getAttribute("src"),r=document.getElementById("tbody"),c=function(t){for(var e=document.querySelectorAll(".table tbody tr"),n=0;n<e.length;n++){var o=e[n].querySelector(".text-left");if(o&&o.textContent.trim()===t)return e[n]}return null}(e);c?(c=c.querySelector(".quantity"),t=parseInt(c.textContent),c.textContent=++t):r.insertAdjacentHTML("beforeend",`
                    <tr>
                        <td><img src="${o}" alt="${e}" style="height: 50px;"></td>
                        <td class="text-left">${e}</td>
                        <td class="d-flex flex-row justify-content-between align-items-center text-center">
                            <button type="button" class="btn btn-sm btn decrement-qty">-</button>
                            <span class="quantity">1</span>
                            <button type="button" class="btn btn-sm btn increment-qty">+</button>
                        </td>
                        <td>Tax</td>
                        <td class="text-center table-item-price">${n}</td>
                        <td class="text-center table-item-subprice">${n}</td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-item">Remove</button></td>
                    </tr>`),0<r.querySelectorAll("tr").length&&(c=r.querySelector(".no-found"))&&c.remove(),u(),l()})}),document.addEventListener("click",function(t){t.target.classList.contains("remove-item")&&(t.target.closest("tr").remove(),u(),l())}),document.addEventListener("click",function(t){var e,n;t.target.classList.contains("increment-qty")&&(e=t.target.previousElementSibling,n=parseInt(e.textContent),e.textContent=++n,u(),l()),t.target.classList.contains("decrement-qty")&&(e=t.target.nextElementSibling,1<(n=parseInt(e.textContent)))&&(e.textContent=--n,u(),l())}),document.querySelector(".discount").addEventListener("input",function(){u(),l()})});