$(document).ready(function(){var r=$("#countrySupplier"),o=$("#currencySupplier");$.ajax({url:"https://restcountries.com/v3.1/all",method:"GET",success:function(e){e.sort(function(e,n){e=e.name.common.toUpperCase(),n=n.name.common.toUpperCase();return e<n?-1:n<e?1:0});var n=e.reduce(function(n,e){e=e.currencies||{};return Object.keys(e).forEach(function(e){n.push(e)}),n},[]),n=Array.from(new Set(n));n.sort(),e.forEach(function(e){e=new Option(e.name.common,e.alpha2Code);r.append(e)}),n.forEach(function(e){e=new Option(e,e);o.append(e)}),r.select3({theme:"minima"}),o.select3({theme:"classic"})},error:function(e){console.error("Error fetching country data:",e)}})});