export const fetchFilms = async () => {
  const response = await fetch('/api/films');
  if (!response.ok) {
    throw new Error('Failed to fetch films');
  }
  return response.json();
};
