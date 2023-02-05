
function amountConversion(amount, conversionType, decimalLimit = null) {
    if (conversionType == 'round') {
        return Math.round(amount);
    }

    if (conversionType == 'floor') {
        return Math.floor(amount);
    }

    if (conversionType == 'ceil') {
        return Math.ceil(amount);
    }

    if (conversionType == 'parseFloat') {
        if (decimalLimit != null) {
            return parseFloat(amount).toFixed(decimalLimit);
        } else {
            return parseFloat(amount);
        }
    }
}