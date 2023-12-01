$(document).ready(function () {
    var countrySelect = $('#countrySupplier');
    var currencySelect = $('#currencySupplier');

    $.ajax({
        url: 'https://restcountries.com/v3.1/all',
        method: 'GET',
        success: function (data) {
            // Sort the data array alphabetically by country name
            data.sort(function (a, b) {
                var nameA = a.name.common.toUpperCase();
                var nameB = b.name.common.toUpperCase();
                if (nameA < nameB) {
                    return -1;
                }
                if (nameA > nameB) {
                    return 1;
                }
                return 0;
            });

            // Extract unique currency codes from all countries
            var allCurrencyCodes = data.reduce(function (currencyCodes, country) {
                var countryCurrencies = country.currencies || {};

                Object.keys(countryCurrencies).forEach(function (currencyCode) {
                    currencyCodes.push(currencyCode);
                });

                return currencyCodes;
            }, []);

            // Remove duplicate currency codes
            var uniqueCurrencyCodes = Array.from(new Set(allCurrencyCodes));

            // Sort currency codes alphabetically
            uniqueCurrencyCodes.sort();

            // Populate the country select dropdown with sorted country options
            data.forEach(function (country) {
                var optionCountry = new Option(country.name.common, country.alpha2Code);
                countrySelect.append(optionCountry);
            });

            // Populate the currency select dropdown with sorted currency options
            uniqueCurrencyCodes.forEach(function (currencyCode) {
                var optionCurrency = new Option(currencyCode, currencyCode);
                currencySelect.append(optionCurrency);
            });

            // Initialize select3 for country and currency
            countrySelect.select3({
                theme: 'minima', // Adjust the theme as needed
            });

            currencySelect.select3({
                theme: 'classic', // Adjust the theme as needed
            });
        },
        error: function (error) {
            console.error('Error fetching country data:', error);
        },
    });
});
