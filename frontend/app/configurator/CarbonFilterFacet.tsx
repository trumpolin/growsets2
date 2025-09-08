"use client";
import ArticleFacet from "./ArticleFacet";

export default function CarbonFilterFacet() {
  return (
    <ArticleFacet
      category="carbon-filter"
      selectionKey="carbonFilter"
      title="Aktivkohlefilter"
      queryKey={["carbonFilterArticles"]}
    />
  );
}
