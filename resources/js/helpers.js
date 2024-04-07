export function shortenText(text, limit) {
    return text.length < limit ? text : text.substring(0, limit) + ' [...]';
}
