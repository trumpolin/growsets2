"use client";
import ArticleFacet from "./ArticleFacet";

export default function CarbonFilterFacet() {
  const category = process.env.NEXT_PUBLIC_CARBON_FILTER_CATEGORY_ID || "";
  return (
    <ArticleFacet
      category={category}
      selectionKey="carbonFilter"
      title="Aktivkohlefilter"
      queryKey={["carbonFilterArticles"]}
    />
  );
}
