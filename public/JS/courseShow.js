function unenrollStudent(courseId, studentId, studentName) {
    if (confirm(`Unenroll student ${studentName}?`)) {
        const form = document.getElementById('unenrollForm');
        form.action = `/courses/${courseId}/students/${studentId}/unenroll`;
        form.submit();
    }
}