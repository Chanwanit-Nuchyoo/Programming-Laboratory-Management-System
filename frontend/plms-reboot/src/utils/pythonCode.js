export const getKwConSourceCode = (userCode) => {
    const escapedUserCode = JSON.stringify(userCode); // Escape special characters

    return escapedUserCode;
};
