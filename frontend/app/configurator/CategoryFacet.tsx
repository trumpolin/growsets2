"use client";
import { fetchCategoryArticles } from "@/lib/api";
import ArticleListItem from "@/components/ArticleListItem";
import FacetPanel from "@/components/FacetPanel";
import { useSelection } from "@/components/SelectionProvider";

export default function CategoryFacet() {
  const { setSelection } = useSelection();
  const { data } = fetchCategoryArticles("default", 1);

  return (
    <FacetPanel title="Articles">
      <ul className="space-y-2">
        {data?.items?.map((article) => (
          <ArticleListItem
            key={article.id}
            article={article}
            onSelect={(id) => setSelection("article", id)}
          />
        ))}
      </ul>
    </FacetPanel>
  );
}
