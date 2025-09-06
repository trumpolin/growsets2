"use client";

interface Article {
  id: string;
  title: string;
  description?: string;
}

export default function ArticleListItem({
  article,
  onSelect,
}: {
  article: Article;
  onSelect?: (id: string) => void;
}) {
  return (
    <li
      className="cursor-pointer rounded border p-2 hover:bg-gray-50"
      onClick={() => onSelect?.(article.id)}
    >
      <h3 className="font-medium">{article.title}</h3>
      {article.description && (
        <p className="text-sm text-gray-600">{article.description}</p>
      )}
    </li>
  );
}
