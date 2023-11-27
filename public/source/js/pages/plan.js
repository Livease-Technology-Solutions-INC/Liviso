const productPrice = document.querySelector('#initial-price');
const addOn = document.querySelector('#addon');
const oneTime = document.querySelector('#onetime');
const admin = document.querySelector('#admin');
const subTotal = document.querySelector('#subTotal');
const dropdown = document.getElementById('inputGroupSelect04');
const discountTextElement = document.getElementById('discount-text');
const discountedPriceElement = document.getElementById('discounted-price');

const subTotalHTML = subTotal.innerHTML;
const extractedProductPrice = productPrice.getAttribute('data-initial-price');
const extractedAddOn = addOn.getAttribute('data-addon');
const extractedOneTime = oneTime.getAttribute('data-addon'); 
const extractedAdmin = admin.getAttribute('data-admin');

function updatePrice(newProductPrice) {
	const calculatedTotal =
		parseInt(newProductPrice) +
		parseInt(extractedAddOn) +
		parseInt(extractedOneTime) +
		parseInt(extractedAdmin);
	subTotal.innerHTML = calculatedTotal;
}

function hideDiscountText() {
	discountTextElement.style.display = 'none';
	discountedPriceElement.innerText = productPrice.innerHTML;
	updatePrice(extractedProductPrice);
}

function showDiscountText(discount) {
	const discountedPrice = (49 - 49 * (discount / 100)).toFixed(0);
	const discountText = discount + '% off';

	discountedPriceElement.innerText = '$' + discountedPrice;
	discountTextElement.innerText = discountText;
	discountTextElement.style.display = 'block';
	updatePrice(discountedPrice);
}

function updateDiscount() {
	const selectedOption = dropdown.options[dropdown.selectedIndex];

	if (selectedOption.value === '0') {
		hideDiscountText();
	} else {
		const discount = selectedOption.getAttribute('data-discount');
		showDiscountText(discount);
	}
}

// Initial setup
updatePrice(extractedProductPrice);
discountTextElement.style.display = 'none';

// Event listener for dropdown change
dropdown.addEventListener('change', updateDiscount);
