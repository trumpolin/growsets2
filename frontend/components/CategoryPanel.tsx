"use client";
import { useQuery } from "@tanstack/react-query";
import FacetPanel from "./FacetPanel";
import ArticleListItem from "./ArticleListItem";
import { fetchCategoryArticles } from "@/lib/api";

interface CategoryPanelProps {
  category: string;
  title: string;
}

export default function CategoryPanel({ category, title }: CategoryPanelProps) {
  const { data } = useQuery({
    queryKey: ["categoryPanel", category],
    queryFn: ({ signal }) => fetchCategoryArticles(category, 1, 5, signal),
  });

  const articles = data?.items ?? [];

  return (
    <FacetPanel title={title}>
      <ul className="space-y-2">
        {articles.map((article) => (
          <ArticleListItem key={article.id} article={article} />
        ))}
      </ul>
    </FacetPanel>
  );
}
