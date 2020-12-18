
export function formatError(errors) {
    let formatted = {};
    if (errors !== undefined && errors !== null && typeof(errors) === 'object') {
        for (let k in errors) {
            let error = errors[k];
            if (Array.isArray(error)) {
                formatted[k] = error[0];
            } else {
                formatted[k] = error;
            
            }
        }
    }
    return formatted;
}