export function formatDate(dateString: string) {
    const date = new Date(dateString);
    return date.toLocaleString("nl-NL", {
        day: "numeric",
        month: "long",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
}
